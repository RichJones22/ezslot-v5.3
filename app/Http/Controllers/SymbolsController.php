<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\SymbolsS;
use Illuminate\Support\Collection;

/**
 * Class SymbolsController.
 */
class SymbolsController extends Controller
{
    private $symbolService;

    /**
     * SymbolsController constructor.
     *
     * @param SymbolsS $symbolService
     */
    public function __construct(SymbolsS $symbolService)
    {
        $this->symbolService = $symbolService;
    }

    /**
     * @return array
     */
    public function symbolsUnique()
    {
        $symbolCollection = $this->symbolService->symbolsUnique();

        // convert the collection to an array
        return $this->convertToJsonableType($symbolCollection);
    }

    /**
     * @param Collection $transactionCollection
     *
     * @return array
     */
    protected function convertToJsonableType(collection $transactionCollection): array
    {
        $data = [];

        $transactions = $transactionCollection->all();

        foreach ($transactions as $transaction) {
            $tmp = [];
            $tmp['text'] = $transaction->underlier_symbol;
            $tmp['value'] = $transaction->underlier_symbol;

            $data[] = $tmp;
        }

        return $data;
    }
}
