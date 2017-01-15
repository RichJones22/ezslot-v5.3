<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\TransactionAggregateE;
use App\Repositories\TransactionAggregateR;
use DB;
use Illuminate\Support\Collection;
use Premise\Utilities\DateTime\CurrentDateTime;

/**
 * Class TransactionAggregateS.
 */
class TransactionAggregateS
{
    /**
     * @var TransactionAggregateR
     */
    private $aggregateR;
    /**
     * @var SymbolsS
     */
    private $symbolS;

    /**
     * TransactionAggregateS constructor.
     *
     * @param TransactionAggregateR $aggregateR
     * @param SymbolsS              $symbolService
     */
    public function __construct(
        TransactionAggregateR $aggregateR,
        SymbolsS $symbolService
    ) {
        $this->aggregateR = $aggregateR;
        $this->symbolS = $symbolService;
    }

    /**
     * @param $symbol
     *
     * @return Collection
     */
    public function getBySymbol($symbol): Collection
    {
        // wrap io in transaction
        $transactions = DB::transaction(function () use ($symbol) {
            return $this->getBySymbolTransaction($symbol);
        });

        return $transactions;
    }

    /**
     * @return Collection
     */
    public function getAllPutTrades(): Collection
    {
        $monthsBack = CurrentDateTime::new()->daysBack(360);

        $result = new Collection();

        $allSymbols = $this
            ->symbolS
            ->symbolsUnique()
            ->all();

        foreach ($allSymbols as $symbol) {
            $transactions = $this
                ->getBySymbolTransaction($symbol->underlier_symbol);

            $tmp = $transactions->filter(function (TransactionAggregateE $x) {
                return $x->getTradeClosed();
            });

            $result->push($tmp->all());
        }

        // flatten into an array; also removes empty $result
        $tmp = [];
        $results = $result->all();
        foreach ($results as $result) {
            foreach ($result as $value) {
                $tmp[] = $value;
            }
        }

        /** @var Collection $tmp */
        $tmp = new Collection($tmp);
        $tmp = $tmp->sort()->reverse();
        $tmp = $tmp->sort()->reverse()->filter(function (TransactionAggregateE $x) use ($monthsBack) {
            return $x->getCloseDate() > $monthsBack;
        });

        return $tmp;
    }

    /**
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function findRemoveSingleBuyItem(Collection $transactions): Collection
    {
        // sort by expiration, which pulls out single buys, that can exist between BUY and SELL close dates
        $transactions = $transactions->sort(function (TransactionAggregateE $a, TransactionAggregateE $b) {
            if ($a->getExpiration() === $b->getExpiration()) {
                return 0;
            }

            return ($a->getExpiration() < $b->getExpiration()) ? -1 : 1;
        });

        $transactions = $this->removeSingleBuys($transactions);

        return $transactions;
    }

    /**
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function removeSingleBuys(Collection $transactions): Collection
    {
        /** @var TransactionAggregateE $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getOptionSide() === 'BUY') {
                $counts = $this->aggregateR->findSingleBuys($transaction);

                foreach ($counts as $count) {
                    if ($count->count === 1) {
                        // pull all other transactions except the one we found, which essentially removes it.
                        $transactions = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
                            if ($x->getTransactionId() !== $transaction->getTransactionId()) {
                                return $x;
                            }

                            return false;
                        });
                    }
                }
            }
        }

        return $transactions;
    }

    /**
     * groups partial fills as one aggregate transaction; much easier to read this way.
     *
     * @param Collection $transactions
     *
     * @return Collection
     */
    protected function consolidateTransactions(Collection $transactions): Collection
    {
        foreach ($transactions as $transaction) {
            $counts = $this->aggregateR->findGroups($transaction);

            foreach ($counts as $count) {
                // check if we have a group to consolidate
                if ($count->count > 1) {
                    // consolidate the group
                    $transactions = $this->consolidateGroup($transactions, $transaction);

                    break;
                }
            }
        }

        return $transactions->sort();
    }

    /**
     * collection manipulation:
     * - squash the group down to a single element
     * - sum the quantity and amount values
     * - place squashed element back on collection
     * - sort the collection.
     *
     * @param Collection $transactions
     * @param $transaction
     *
     * @return Collection
     */
    protected function consolidateGroup(Collection $transactions, TransactionAggregateE $transaction): Collection
    {
        // pull out the group.
        $toSum = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
            if ($x->getCloseDate() === $transaction->getCloseDate() &&
                $x->getUnderlierSymbol() === $transaction->getUnderlierSymbol() &&
                $x->getOptionSide() === $transaction->getOptionSide()
            ) {
                return $x;
            }

            return false;
        });

        // sum the amounts
        $sumAmount = $toSum->reduce(function ($carry, TransactionAggregateE $item) {
            return $carry += $item->getAmount();
        });

        // sum the quantities
        $sumQuantity = $toSum->reduce(function ($carry, TransactionAggregateE $item) {
            return $carry += $item->getOptionQuantity();
        });

        // create the summed element
        /** @var TransactionAggregateE $toAddBack */
        $toAddBack = $toSum->first();
        $toAddBack->setAmount($sumAmount);
        $toAddBack->setOptionQuantity($sumQuantity);

        // remove the group from the array
        $newArray = $transactions->filter(function (TransactionAggregateE $x) use ($transaction) {
            if ($x->getCloseDate() !== $transaction->getCloseDate() ||
                $x->getUnderlierSymbol() !== $transaction->getUnderlierSymbol() ||
                $x->getOptionSide() !== $transaction->getOptionSide()
            ) {
                return $x;
            }

            return false;
        });

        // add the summed element back to the array
        $newArray[] = $toAddBack;

        // sort the array.
        $transactions = $newArray->sort();

        return $transactions;
    }

    /**
     * @param Collection $transactions
     * @param $tradeProfit
     *
     * @return Collection
     */
    protected function determineTradeProfits(Collection $transactions, $tradeProfit): Collection
    {
        $count = $transactions->count();
        $i = 0;
        /** @var TransactionAggregateE $transaction */
        foreach ($transactions as $transaction) {
            $tradeProfit += $transaction->getAmount();

            if ($this->didTradeEnd($transaction, $count, $i)) {
                $transaction->setProfits($tradeProfit);
                $tradeProfit = 0;

                $this->setTradeCloseValue($transaction);
            } else {
                $transaction->setProfits(0);
            }
            ++$i;
        }

        return $transactions;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     * @param $count
     * @param $i
     *
     * @return bool
     */
    protected function didTradeEnd(TransactionAggregateE $aggregateE, $count, $i): bool
    {
        // determine if trade has ended.
        if ($aggregateE->getOptionSide() === 'BUY') {
            $counts = $this->aggregateR->findSellSideTrades($aggregateE);

            foreach ($counts as $count) {
                if ($count->count === 0) {
                    return true;
                }
            }
        } elseif ($aggregateE->getOptionSide() === 'SELL') {
            if ($count !== $i) {
                $counts = $this->aggregateR->findTrades($aggregateE);

                foreach ($counts as $count) {
                    if (CurrentDateTime::new()->currentDate() > $aggregateE->getExpiration()) {
                        if ($count->count === 1) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param $symbol
     * @param null $fromDate
     *
     * @return Collection
     */
    protected function getBySymbolTransaction($symbol, $fromDate = null): Collection
    {
        $tradeProfit = 0;

        // get all trades by symbol
        $CollectionAggregateE = $this
            ->aggregateR
            ->getAllOptionsHouseTransactionsBySymbol($symbol);

        // cull single buy options; this technique is for selling and rolling sold options
        $transactions = $this->findRemoveSingleBuyItem($CollectionAggregateE);

        // consolidate transactions
        $transactions = $this->consolidateTransactions($transactions);

        // calculate trade breaks and profits per trade
        /* @var TransactionAggregateE $transaction */
        $this->determineTradeProfits($transactions, $tradeProfit);

        return $transactions;
    }

    /**
     * @param TransactionAggregateE $transaction
     */
    protected function setTradeCloseValue(TransactionAggregateE $transaction)
    {
        if ($transaction->getCloseDate() < CurrentDateTime::new()->currentDate()) {
            $transaction->setTradeClosed(true);
        } else {
            $transaction->setTradeClosed(false);
        }
    }
}
