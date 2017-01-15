<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\TransactionAggregateE;
use App\Services\TransactionAggregateS;
use Cache;
use Illuminate\Support\Collection;

/**
 * Class TransactionController.
 */
class TransactionController extends Controller
{
    /** @var TransactionAggregateS TransactionAggregateS */
    private $transactionAggregateS;

    /**
     * TransactionController constructor.
     *
     * @param TransactionAggregateS $aggregateS
     */
    public function __construct(TransactionAggregateS $aggregateS)
    {
        $this->transactionAggregateS = $aggregateS;
    }

    /**
     * @return mixed
     */
    public function reports()
    {
        return view('reports');
    }

    /**
     * @param $symbol
     *
     * @return mixed
     */
    public function getBySymbol($symbol)
    {
        // derive TransactionAggregateE collection
        $CollectionAggregateE = $this
            ->transactionAggregateS
            ->getBySymbol($symbol);

        // convert to Jsonable return type
        return $this->convertToJsonableType($CollectionAggregateE);
    }

    /**
     * @return array
     */
    public function getSymbolsThatClosedForPeriod()
    {
        $data = Cache::get('getAllPutTrades');
        if ($data) {
            return json_decode($data);
        }

        $CollectionAggregateE = $this
            ->transactionAggregateS
            ->getAllPutTrades();

        return $this->convertToJsonableType($CollectionAggregateE);
    }

    /**
     * @param Collection $CollectionAggregateE
     *
     * @return array
     */
    protected function convertToJsonableType(Collection $CollectionAggregateE): array
    {
        $data = [];

        // convert the collection to an array
        $transactions = $CollectionAggregateE->all();

        // convert the array a jsonable return type
        /** @var TransactionAggregateE $transaction */
        foreach ($transactions as $transaction) {
            $data[] = $transaction->toArray();
        }

        Cache::put('getAllPutTrades', json_encode($data), 60);

        return $data;
    }
}
