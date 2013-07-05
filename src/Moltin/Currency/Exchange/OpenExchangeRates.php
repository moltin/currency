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
