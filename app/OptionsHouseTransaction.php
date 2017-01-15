<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionsHouseTransaction extends Model
{
    /**
     *  table used by this model.
     */
    protected $table = 'options_house_transaction';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'close_date',
        'close_time',
        'trade_type',
        'description',
        'strike_price',
        'option_type',
        'option_side',
        'option_quantity',
        'symbol',
        'price_per_unit',
        'underlier_symbol',
        'fee',
        'commission',
        'amount',
        'security_type',
        'expiration',
        'security_description',
        'position_state',
        'deliverables',
        'market_statistics',
        'trade_journal_notes',
    ];

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->attributes['transaction_id'];
    }

    /**
     * @param $setTransactionId
     */
    public function setTransactionId($setTransactionId)
    {
        $this->attributes['transaction_id'] = $setTransactionId;
    }

    /**
     * @return mixed
     */
    public function getCloseDate()
    {
        return $this->attributes['close_date'];
    }

    /**
     * @param $setCloseDate
     */
    public function setCloseDate($setCloseDate)
    {
        $this->attributes['close_date'] = $setCloseDate;
    }

    /**
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->attributes['close_time'];
    }

    /**
     * @param $setCloseTime
     */
    public function setCloseTime($setCloseTime)
    {
        $this->attributes['close_time'] = $setCloseTime;
    }

    /**
     * @return mixed
     */
    public function getTradeType()
    {
        return $this->attributes['trade_type'];
    }

    /**
     * @param $setTradeType
     */
    public function setTradeType($setTradeType)
    {
        $this->attributes['trade_type'] = $setTradeType;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->attributes['description'];
    }

    /**
     * @param $setDescription
     */
    public function setDescription($setDescription)
    {
        $this->attributes['description'] = $setDescription;
    }

    /**
     * @return mixed
     */
    public function getStrikePrice()
    {
        return $this->attributes['strike_price'];
    }

    /**
     * @param $setStrikePrice
     */
    public function setStrikePrice($setStrikePrice)
    {
        $this->attributes['strike_price'] = $setStrikePrice;
    }

    /**
     * @return mixed
     */
    public function getOptionType()
    {
        return $this->attributes['option_type'];
    }

    /**
     * @param $setOptionType
     */
    public function setOptionType($setOptionType)
    {
        $this->attributes['option_type'] = $setOptionType;
    }

    /**
     * @return mixed
     */
    public function getOptionSide()
    {
        return $this->attributes['option_side'];
    }

    /**
     * @param $setOptionSide
     */
    public function setOptionSide($setOptionSide)
    {
        $this->attributes['option_side'] = $setOptionSide;
    }

    /**
     * @return mixed
     */
    public function getOptionQuantity()
    {
        return $this->attributes['option_quantity'];
    }

    /**
     * @param $setOptionQuantity
     */
    public function setOptionQuantity($setOptionQuantity)
    {
        $this->attributes['option_quantity'] = $setOptionQuantity;
    }

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->attributes['symbol'];
    }

    /**
     * @param $setSymbol
     */
    public function setSymbol($setSymbol)
    {
        $this->attributes['symbol'] = $setSymbol;
    }

    /**
     * @return mixed
     */
    public function getPricePerUnit()
    {
        return $this->attributes['price_per_unit'];
    }

    /**
     * @param $setPricePerUnit
     */
    public function setPricePerUnit($setPricePerUnit)
    {
        $this->attributes['price_per_unit'] = $setPricePerUnit;
    }

    /**
     * @return mixed
     */
    public function getUnderlierSymbol()
    {
        return $this->attributes['underlier_symbol'];
    }

    /**
     * @param $setUnderlierSymbol
     */
    public function setUnderlierSymbol($setUnderlierSymbol)
    {
        $this->attributes['underlier_symbol'] = $setUnderlierSymbol;
    }

    /**
     * @return mixed
     */
    public function getFee()
    {
        return $this->attributes['fee'];
    }

    /**
     * @param $setFee
     */
    public function setFee($setFee)
    {
        $this->attributes['fee'] = $setFee;
    }

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->attributes['commission'];
    }

    /**
     * @param $setCommission
     */
    public function setCommission($setCommission)
    {
        $this->attributes['commission'] = $setCommission;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->attributes['amount'];
    }

    /**
     * @param $setAmount
     */
    public function setAmount($setAmount)
    {
        $this->attributes['amount'] = $setAmount;
    }

    /**
     * @return mixed
     */
    public function getSecurityType()
    {
        return $this->attributes['security_type'];
    }

    /**
     * @param $setSecurityType
     */
    public function setSecurityType($setSecurityType)
    {
        $this->attributes['security_type'] = $setSecurityType;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->attributes['expiration'];
    }

    /**
     * @param $setExpiration
     */
    public function setExpiration($setExpiration)
    {
        $this->attributes['expiration'] = $setExpiration;
    }

    /**
     * @return mixed
     */
    public function getSecurityDescription()
    {
        return $this->attributes['security_description'];
    }

    /**
     * @param $setSecurityDescription
     */
    public function setSecurityDescription($setSecurityDescription)
    {
        $this->attributes['security_description'] = $setSecurityDescription;
    }

    /**
     * @return mixed
     */
    public function getPositionState()
    {
        return $this->attributes['position_state'];
    }

    /**
     * @param $setPositionState
     */
    public function setPositionState($setPositionState)
    {
        $this->attributes['position_state'] = $setPositionState;
    }

    /**
     * @return mixed
     */
    public function getDeliverables()
    {
        return $this->attributes['deliverables'];
    }

    /**
     * @param $setDeliverables
     */
    public function setDeliverables($setDeliverables)
    {
        $this->attributes['deliverables'] = $setDeliverables;
    }

    /**
     * @return mixed
     */
    public function getMarketStatistics()
    {
        return $this->attributes['market_statistics'];
    }

    /**
     * @param $setMarketStatistics
     */
    public function setMarketStatistics($setMarketStatistics)
    {
        $this->attributes['market_statistics'] = $setMarketStatistics;
    }

    /**
     * @return mixed
     */
    public function getTradeJournalNotes()
    {
        return $this->attributes['trade_journal_notes'];
    }

    /**
     * @param $setTradeJournalNotes
     */
    public function setTradeJournalNotes($setTradeJournalNotes)
    {
        $this->attributes['trade_journal_notes'] = $setTradeJournalNotes;
    }
}
