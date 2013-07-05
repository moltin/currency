<?php

/**
 * This file is part of Moltin Currency, a PHP library to process, format and
 * convert values between various currencies and formats.
 *
 * Copyright (c) 2013 Moltin Ltd.
 * http://github.com/moltin/currency
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package moltin/currency
 * @author Jamie Holdroyd <jamie@molt.in>
 * @author Chris Harvey <chris@molt.in>
 * @copyright 2013 Moltin Ltd.
 * @version dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency;

class Currency
{
    protected $exchange;
    protected $original =  0;
    protected $value    =  0;

    public function __construct(ExchangeInterface $exchange, FormatInterface $format)
    {
        $this->exchange = $exchange;
        $this->format   = $format;
    }

    public function convert($value, $new = true)
    {
        $clone = $this;

        if ($new) $clone = clone $this;

        $clone->value = $value;

        return $clone;
    }

    public function from($code)
    {
        $this->currency = $code;
    }

    public function to($code)
    {
        // Get selected currency
        if ($currency = $this->exchange->convert($this->from, $code, $this->value)) {

            // Assign new values
            $this->value = $currency['value'];
            $this->currency = $code;

        }

        return $this;
    }

    public function format()
    {
        // Variables
        $value    = $this->value;
        $format   = $this->data['format'];
        $decimal  = $this->data['decimal'];
        $thousand = $this->data['thousand'];

        // Format
        $formatted = number_format($value, 2, $decimal, $thousand);
        $formatted = str_replace('{price}', $formatted, $format);

        return $formatted;
    }

    public function value()
    {
        return $this->value;
    }

    public function original()
    {
        return $this->original;
    }

    public function currency()
    {
        return $this->data;
    }

    public function zeros()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = ceil($value).$decimal.'00';
        $formatted = number_format($formatted, 2, $decimal, false);

        // Assign it
        $this->value = (float)$formatted;

        return $this;
    }

    public function nines()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = ceil($value) - 0.01;
        $formatted = number_format($formatted, 2, $decimal, false);

        // Assign it
        $this->value = (float)$formatted;

        return $this;
    }

    public function fifty()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = (round($value * 2, 0) / 2);
        $formatted = number_format($formatted, 2, $decimal, false);

        // Assign it
        $this->value = (float)$formatted;

        return $this;
    }

    public function reset()
    {
        $this->value = $this->original;
        return $this;
    }

    public function setExchange(ExchangeInterface $exchange)
    {
        $this->exchange = $exchange;
    }

    public function setCurrency(array $currency)
    {
        foreach ($currency as $key => $value) {

            if (isset($this->data[$key])) $this->data[$key] = $value;

        }

        $this->reset();

        return $this;
    }
    
    public function __get($property)
    {
        return $this->data[$property];
    }

    public function __toString()
    {
        return $this->format();
    }

}
