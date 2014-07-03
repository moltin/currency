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
    protected $appId;
    protected $url  =  'http://openexchangerates.org/api/latest.json?app_id={app_id}';
    protected $stored = array();

    public function __construct($appId)
    {
        $this->appId = $appId;
    }

    public function get($code)
    {
        $this->download();

        if ( ! isset($this->stored['rates'][$code])) {
            throw new ExchangeException("No rate for '{$code}'");
        }

        return $this->stored['rates'][$code];
    }

    protected function download()
    {
        if ( ! empty($this->stored)
            and $this->base == $this->stored['base']) return;

        $request = new Client($this->url, array(
            'app_id' => $this->appId
        ));

        $json = $request->get()->send()->json();

        // Error check
        if (isset($json['error'])) throw new ExchangeException($json['error']);

        $data = $json;
        $data['base'] = $this->base;

        foreach ($data['rates'] as &$rate)
        {
            // Do we need to cross-convert?
            if ($json['base'] != $this->base) {
                $new = $rate * (1 / $json['rates'][$this->base]);
                $rate = round($new, 6);
            }
        }

        $this->stored = $data;
    }

}
