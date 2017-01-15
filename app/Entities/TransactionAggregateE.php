<?php

declare(strict_types=1);

namespace App\Entities;

use Illuminate\Support\Str;

/**
 * Class TransactionAggregateE.
 */
class TransactionAggregateE
{
    /** @var string */
    private $close_date;
    /** @var string */
    private $underlier_symbol;
    /** @var string */
    private $position_state;
    /** @var string */
    private $option_side;
    /** @var int */
    private $option_quantity;
    /** @var float */
    private $strike_price;
    /** @var string */
    private $expiration;
    /** @var float */
    private $amount;
    /** @var string */
    private $symbol;
    /** @var int */
    private $transaction_id;

    // aggregates
    private $profits;

    /** @var bool */
    private $tradeClosed;

    /**
     * @return mixed
     */
    public function getTradeClosed()
    {
        return $this->tradeClosed;
    }

    /**
     * @param mixed $tradeClosed
     */
    public function setTradeClosed(bool $tradeClosed)
    {
        $this->tradeClosed = $tradeClosed;
    }

    /**
     * @return mixed
     */
    public function getProfits()
    {
        return $this->profits;
    }

    /**
     * @param mixed $profits
     */
    public function setProfits($profits)
    {
        $this->profits = $profits;
    }

    /**
     * @return mixed
     */
    public function getCloseDate()
    {
        return $this->close_date;
    }

    /**
     * @param $close_date
     *
     * @return TransactionAggregateE
     */
    public function setCloseDate($close_date): TransactionAggregateE
    {
        $this->close_date = $close_date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUnderlierSymbol()
    {
        return $this->underlier_symbol;
    }

    /**
     * @param $underlier_symbol
     *
     * @return TransactionAggregateE
     */
    public function setUnderlierSymbol($underlier_symbol): TransactionAggregateE
    {
        $this->underlier_symbol = $underlier_symbol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPositionState()
    {
        return $this->position_state;
    }

    /**
     * @param $position_state
     *
     * @return TransactionAggregateE
     */
    public function setPositionState($position_state): TransactionAggregateE
    {
        $this->position_state = $position_state;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionSide()
    {
        return $this->option_side;
    }

    /**
     * @param $option_side
     *
     * @return TransactionAggregateE
     */
    public function setOptionSide($option_side): TransactionAggregateE
    {
        $this->option_side = $option_side;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptionQuantity()
    {
        return $this->option_quantity;
    }

    /**
     * @param $option_quantity
     *
     * @return TransactionAggregateE
     */
    public function setOptionQuantity($option_quantity): TransactionAggregateE
    {
        $this->option_quantity = $option_quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStrikePrice()
    {
        return $this->strike_price;
    }

    /**
     * @param $strike_price
     *
     * @return TransactionAggregateE
     */
    public function setStrikePrice($strike_price): TransactionAggregateE
    {
        $this->strike_price = $strike_price;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param $expiration
     *
     * @return TransactionAggregateE
     */
    public function setExpiration($expiration): TransactionAggregateE
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param $amount
     *
     * @return TransactionAggregateE
     */
    public function setAmount($amount): TransactionAggregateE
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param $symbol
     *
     * @return TransactionAggregateE
     */
    public function setSymbol($symbol): TransactionAggregateE
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * @param $transaction_id
     *
     * @return TransactionAggregateE
     */
    public function setTransactionId($transaction_id): TransactionAggregateE
    {
        $this->transaction_id = $transaction_id;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $result = [];

        $vars = get_class_vars(get_class($this));
        foreach ($vars as $key => $value) {
            $method = 'get'.ucfirst(Str::camel($key));
            $result[$key] = $this->$method();
        }

        return $result;
    }
}
