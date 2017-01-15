<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\TransactionAggregateE;
use App\OptionsHouseTransaction;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class TransactionAggregateR.
 */
class TransactionAggregateR
{
    /**
     * @var array
     */
    private $tradeWhere = ['Trade'];

    /**
     * @var string
     */
    private $fromDate = '1900-01-01';

    /**
     * @var TransactionAggregateE
     */
    private $TransactionAggregateE;
    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var Model
     */
    private $model;

    /**
     * TransactionAggregateR constructor.
     *
     * @param OptionsHouseTransaction $optionsHouseTransaction
     * @param Collection              $collection
     * @param TransactionAggregateE   $aggregateE
     */
    public function __construct(
        OptionsHouseTransaction $optionsHouseTransaction,
        Collection $collection,
        TransactionAggregateE $aggregateE
    ) {
        $this->model = $optionsHouseTransaction;
        $this->TransactionAggregateE = $aggregateE;
        $this->collection = $collection;
    }

    /**
     * @param $symbol
     *
     * @return Collection
     */
    public function getAllOptionsHouseTransactionsBySymbol($symbol): Collection
    {
        /** @var Collection<StdClass> $transactions */
        $transactions = DB::table('options_house_transaction')
            ->select(
                'close_date',
                'underlier_symbol',
                'position_state',
                'option_side',
                'option_quantity',
                'strike_price',
                'expiration',
                'amount',
                'symbol',
                'transaction_id')
            ->whereIn('trade_type', $this->tradeWhere)
            ->where('underlier_symbol', $symbol)
            ->where('security_type', 'OPTION')
            ->where('close_date', '>', $this->fromDate)
            ->orderBy('close_date', 'desc')
//            ->orderBy('option_side', 'asc')
//            ->orderBy('expiration', 'asc')
            ->get();

        // derive TransactionAggregateE collection
        return $this->hydrate($transactions);
    }

    /**
     * persist entity to db.
     *
     * @param Collection $transactions<TransactionAggregateE>
     */
    public function save(Collection $transactions)
    {
        foreach ($transactions as $transaction) {
            /** @var Model $model */
            $model = new $this->model();

            foreach ($transaction as $key => $value) {
                $model->setAttribute($key, $value);
            }

            $model->save();
        }
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findSingleBuys(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->whereIn('trade_type', $this->tradeWhere)
            ->where('expiration', $aggregateE->getExpiration())
            ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
            ->where('security_type', 'OPTION')
            ->get();

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findGroups(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->where('expiration', $aggregateE->getExpiration())
            ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
            ->where('option_side', $aggregateE->getOptionSide())
            ->where('security_type', 'OPTION')
            ->get();

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findSellSideTrades(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->where('close_date', $aggregateE->getCloseDate())
            ->where('underlier_symbol', $aggregateE->getUnderlierSymbol())
            ->where('option_side', 'SELL')
            ->where('security_type', 'OPTION')
            ->whereIn('trade_type', $this->tradeWhere)
            ->get();

        return $counts;
    }

    /**
     * @param TransactionAggregateE $aggregateE
     *
     * @return Collection
     */
    public function findTrades(TransactionAggregateE $aggregateE): Collection
    {
        $counts = DB::table('options_house_transaction')
            ->select(DB::raw('count(*) as count'))
            ->where('symbol', $aggregateE->getSymbol())
//                ->where('close_date', $aggregateE->getCloseDate())
            ->where('security_type', 'OPTION')
            ->whereIn('trade_type', $this->tradeWhere)
            ->get();

        return $counts;
    }

    /**
     * @param string|null $fromDate
     *
     * @return $this
     */
    public function setFromDate(string $fromDate = null)
    {
        if ( ! empty($fromDate)) {
            $this->fromDate = $fromDate;
        }

        return $this;
    }

    /**
     * populate the entity with model data.
     *
     * @param Collection $transactions<Model StdClass>
     *
     * @return Collection<TransactionAggregateE>
     */
    protected function hydrate(Collection $transactions): Collection
    {
        /** @var Collection $transactionAggregateCollection */
        $transactionAggregateCollection = new $this->collection();

        foreach ($transactions as $transaction) {
            /** @var TransactionAggregateE $transactionAggregate */
            $transactionAggregate = new $this->TransactionAggregateE();

            foreach ($transaction as $key => $value) {
                $method = 'set'.ucfirst(Str::camel($key));
                $transactionAggregate->$method($value);
            }

            $transactionAggregateCollection->push($transactionAggregate);
        }

        return $transactionAggregateCollection;
    }
}
