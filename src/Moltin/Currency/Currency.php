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
 * @version dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency;

use Moltin\Currency\Exception\CurrencyException;
use Moltin\Currency\Exception\ExchangeException;

class Currency
{

    protected $exchange;
    protected $original =  0;
    protected $value    =  0;
    protected $data     =  array(
        'code'     => 'GBP',
        'format'   => '&pound;{price}',
        'decimal'  => '.',
        'thousand' => ','
    );

    public function __construct(ExchangeInterface $exchange, $args = null)
    {
        // Assign exchange
        $this->exchange = $exchange;

        // Loop and assign arguments
        if ( $args !== null and is_array($args) ) {
            foreach ( $args as $key => $value ) {
                if ( isset($this->data[$key]) ) { $this->data[$key] = $value; }
            }
        }
    }

    public function convert($code)
    {
        // Variables
        $value    = $this->value;
        $currency = $this->data['code'];

        // Get selected currency
        if ( $currency = $this->exchange->convert($currency, $code, $value) ) {

            // Assign new values
            $this->value   =  $currency['value'];
            $this->data    =  array(
                'code'     => $code,
                'format'   => $currency['format'],
                'decimal'  => $currency['decimal'],
                'thousand' => $currency['thousand']
            );

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
        $format   = $this->data['format'];
        $decimal  = $this->data['decimal'];
        $thousand = $this->data['thousand'];

        // Format
        $formatted = number_format($value, 2, $decimal, $thousand);
        $formatted = str_replace('{price}', $formatted, $format);

        return $formatted;
    }

    public function zeros()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = ceil($value).$decimal.'00';
        $formatted = number_format($value, 2, $decimal, false);

        // Assign it
        $this->value = $formatted;

        return $this;
    }

    public function nines()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = ceil($value) - 0.01;
        $formatted = number_format($value, 2, $decimal, false);

        // Assign it
        $this->value = $formatted;

        return $this;
    }

    public function fifty()
    {
        // Variables
        $value   = $this->value;
        $decimal = $this->data['decimal'];

        // Format
        $formatted = ( round(( $value * 2 ), 0) / 2 );
        $formatted = number_format($value, 2, $decimal, false);

        // Assign it
        $this->value = $formatted;

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
    
    public function __get($property)
    {
        return $this->data[$property];
    }

}
