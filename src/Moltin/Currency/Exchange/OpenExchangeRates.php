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

namespace Moltin\Currency\Exchange;

use Moltin\Currency\Exception\CurrencyException;
use Moltin\Currency\Exception\ExchangeException;

class OpenExchangeRates implements \Moltin\Currency\ExchangeInterface
{

	protected $store;
	protected $currencies;
	protected $url  =  'http://openexchangerates.org/api/latest.json?app_id=';
	protected $data =  array(
		'base'      => 'GBP',
		'app_id'    => ''
	);

	public function __construct(\Moltin\Currency\StorageInterface $store, \Moltin\Currency\CurrenciesInterface $currencies, $args = array())
	{
		// Assign variables
		$this->store      = $store;
		$this->currencies = $currencies;

        // Loop and assign arguments
        if ($args !== null and is_array($args)) {
            foreach ($args as $key => $value) {
                if (isset($this->data[$key])) $this->data[$key] = $value;
            }
        }
	}

	public function update()
	{
		// Variables
		$json = $this->_download();
		$base = $this->data['base'];

		// Loop and store
		foreach ($json->rates as $code => $rate)
		{
			// Check we need this
            if ( ! array_key_exists($code, $this->currencies->available)) continue;

            // Multiplier
            $multi = 1;

            // Do we need to cross-convert?
            if ($json->base != $base) {
                $new   = $rate * (1 / $json->rates->$base);
                $multi = round($new, 6);
            }

            // Store
            $this->store->insertUpdate($code, $multi);
		}

		return $this;
	}

	public function get($code)
	{
		return $this->store->get($code);
	}

	public function convert($from, $to, $value)
	{

		// Variables
		$currency = $this->currencies->get($to);
		$frate    = $this->get($from);
		$trate    = $this->get($to);
		$base     = $this->data['base'];

		// Check we got from
		if ($frate === null) throw new ExchangeException('Currency ('.$from.') not found');

		// Check we got to
		if ($trate === null) throw new ExchangeException('Currency ('.$to.') not found');

		// Cross conversion
		if ($from != $base) {
            $new   = ( $trate * ( 1 / $frate ) );
            $trate = round($new, 6);
        }

		// Return formatted value
        return array(
        	'value'    => $value * $trate,
        	'format'   => $currency['format'],
        	'decimal'  => $currency['decimal'],
        	'thousand' => $currency['thousand']
        );
	}

	public function _download()
	{

		// Variables
        $url = $this->url.$this->data['app_id'];

        // Check key
        if ( ! isset($this->data['app_id']) or $this->data['app_id'] == '') {
        	throw new CurrencyException('No App ID Set');
        }

        // Get data
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        // Convert
        $json = json_decode($data);

        // Error check
        if (isset($json->error)) throw new CurrencyException($json->error);

        return $json;
	}

}
