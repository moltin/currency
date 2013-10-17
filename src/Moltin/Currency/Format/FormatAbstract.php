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

namespace Moltin\Currency\Format;

abstract class FormatAbstract
{
    public function zeros($value, $code)
    {
        $data = $this->get($code);

        // Format
        $formatted = ceil($value).$data['decimal'].'00';
        $formatted = number_format($formatted, 2, $data['decimal'], false);

        // Assign it
        return (float)$formatted;
    }

    public function nines($value, $code)
    {
        $data = $this->get($code);

        // Format
        $formatted = ceil($value) - 0.01;
        $formatted = number_format($formatted, 2, $data['decimal'], false);

        // Assign it
        return (float)$formatted;
    }

    public function fifty($value, $code)
    {
        $data = $this->get($code);

        // Format
        $formatted = (round($value * 2, 0) / 2);
        $formatted = number_format($formatted, 2, $data['decimal'], false);

        // Assign it
        return (float)$formatted;
    }
}
