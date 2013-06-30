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

namespace Moltin\Currency\Exchange;

use Moltin\Currency\StorageInterface;
use Moltin\Currency\CurrenciesInterface;

abstract class ExchangeAbstract
{
    public function __construct(StorageInterface $store, CurrenciesInterface $currencies, array $args = array())
    {
        // Assign variables
        $this->store      = $store;
        $this->currencies = $currencies;

        // Loop and assign arguments
        foreach ($args as $key => $value) {
            if (isset($this->data[$key])) $this->data[$key] = $value;
        }
    }

    public function get($code)
    {
        return $this->store->get($code);
    }
}