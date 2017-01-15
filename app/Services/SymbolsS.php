<?php declare(strict_types=1);

namespace App\Services;

use DB;
use Illuminate\Support\Collection;

/**
 * Class SymbolService.
 */
class SymbolsS
{
    /** @var string */
    public $fromDate = '1900-01-01';

    /**
     * @return Collection
     */
    public function symbolsUnique(): Collection
    {
        $symbolCollection = DB::table('options_house_transaction')
            ->select('underlier_symbol')
            ->orderBy('underlier_symbol', 'asc')
            ->groupBy('underlier_symbol')
            ->where('underlier_symbol', '<>', '')
            ->where('close_date', '>', $this->fromDate)
            ->get();

        return $symbolCollection;
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
}
