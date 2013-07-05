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

use Guzzle\Http\Client;
use Moltin\Currency\StorageInterface;
use Moltin\Currency\CurrenciesInterface;
use Moltin\Currency\Exception\ExchangeException;

class OpenExchangeRates extends ExchangeAbstract implements \Moltin\Currency\ExchangeInterface
{
    protected $url  =  'http://openexchangerates.org/api/latest.json?app_id={app_id}';
    protected $data =  array(
        'base'      => 'GBP',
        'app_id'    => ''
    );

    private $stored = array();

    public function __construct(array $args = array())
    {
        parent::__construct($args);

        $this->download();
    }

    public function get($code)
    {
        return $this->stored['rates'][$code];
    }

    public function update()
    {
        // Variables
        $base = $this->stored['base'];

        // Loop and store
        foreach ($this->stored['rates'] as $code => $rate)
        {
            // Check we need this
            if ( ! array_key_exists($code, $this->currencies->available)) continue;

            // Multiplier
            $multi = 1;

            // Do we need to cross-convert?
            if ($this->stored['base'] != $base) {
                $new   = $rate * (1 / $this->stored['rates'][$base]);
                $multi = round($new, 6);
            }
        }

        return $this;
    }

    public function convert($value, $from, $to)
    {
        // Variables
        $frate    = $this->get($from);
        $trate    = $this->get($to);

        // Cross conversion
        $new   = $trate * (1 / $frate);
        $trate = round($new, 6);

        // Return formatted value
        return $value * $trate;
    }

    protected function download()
    {
        // Check key
        if ( ! isset($this->data['app_id']) or $this->data['app_id'] == '') {
            throw new ExchangeException('No App ID Set');
        }

        $request = new Client($this->url, array(
            'app_id' => $this->data['app_id']
        ));

        $json = $request->get()->send()->json();

        // Error check
        if (isset($json['error'])) throw new ExchangeException($json['error']);

        $this->stored = $json;
    }

}
