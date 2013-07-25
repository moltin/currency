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
    protected $base = 'USD';

    public function convert($value, $from, $to)
    {
        // Variables
        $frate = $this->get($from);
        $trate = $this->get($to);

        // Cross conversion
        if ($this->base != $from) {
            $new   = $trate * (1 / $frate);
            $trate = round($new, 6);
        }

        // Return formatted value
        return $value * $trate;
    }
}