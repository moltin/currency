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

use Moltin\Currency\Exception\FormatException;

class Runtime extends FormatAbstract implements \Moltin\Currency\FormatInterface
{
    public $available = array(
        'GBP' => array(
            'format'      => '&pound;{price}',
            'decimal'     => '.',
            'thousand'    => ','
        ),
        'USD' => array(
            'format'      => '${price}',
            'decimal'     => '.',
            'thousand'    => ','
        ),
        'EUR' => array(
            'format'      => '&euro;{price}',
            'decimal'     => ',',
            'thousand'    => ' '
        )
    );

    public function format($value, $as)
    {
        $data = $this->get($as);

        $formatted = number_format($value, 2, $data['decimal'], $data['thousand']);
        $formatted = str_replace('{price}', $formatted, $data['format']);

        return $formatted;

    }

    public function get($code)
    {
        if ( ! isset($this->available[$code])) {
            throw new FormatException("Currency '{$code}' not found");
        }

        return $this->available[$code];
    }

    public function exists($code)
    {
        return array_key_exists($code, $this->available);
    }

    public function add($code, $format, $decimal, $thousand)
    {
        $this->available[$code] = array(
            'format' => $format,
            'decimal' => $decimal,
            'thousand' => $thousand
        );
    }

    public function update($code, $format, $decimal, $thousand)
    {
        $this->add($code, $format, $decimal, $thousand);
    }

    public function remove($code)
    {
        unset($this->available[$code]);
    }
}
