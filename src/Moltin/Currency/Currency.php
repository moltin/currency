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
 * @copyright 2013 Moltin Ltd.
 * @version 0.1.1-dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency;

use Moltin\Currency\Exception\CurrencyException;
use Moltin\Currency\Exception\ExchangeException;

class Currency
{

    protected $store;
    protected $value    = 0;
    protected $currency = 'GBP';
    protected $format   = '&pound;{price}';
    protected $decimal  = '.';
    protected $thousand = ',';

    public function __construct($args)
    {
        // Get and loop arguments
        foreach ( $args as $key => $value ) {
            if ( isset($this->$key) ) {
                $this->$key = $value;
            }
        }
    }

    public function convert($code)
    {
        // Get selected currency
        if ( $currency = $this->store->get($code) ) {

            // TODO: This part

        }

        return $this;
    }

    public function value()
    {
        return $this->value;
    }

    public function currency()
    {
        // Variables
        $value    = $this->value;
        $format   = $this->format;
        $decimal  = $this->decimal;
        $thousand = $this->thousand;

        // Format
        $formatted = number_format($value, 2, $decimal, $thousand);
        $formatted = str_replace('{price}', $formatted, $format);

        return $formatted;
    }

    public function zeros()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->decimal;

        // Format
        $formatted = ceil($value).$decimal.'00';
        $formatted = number_format($value, 2, $decimal, false);

        return $formatted;
    }

    public function nines()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->decimal;

        // Format
        $formatted = ceil($value) - 0.01;
        $formatted = number_format($value, 2, $decimal, false);

        return $formatted;
    }

    public function fifty()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->decimal;

        // Format
        $formatted = ( round(( $value * 2 ), 0) / 2 );
        $formatted = number_format($value, 2, $decimal, false);

        return $formatted;
    }

}
