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
use Moltin\Currency\Exception\CurrencyException;
use Moltin\Currency\Exception\ExchangeException;

class File implements \Moltin\Currency\ExchangeInterface
{

	protected $store;
	protected $currencies;
	protected $data =  array(
		'base'      => 'GBP'
	);

	public function __construct(StorageInterface $store, CurrenciesInterface $currencies, $args = array())
	{
		// Assign variables
		$this->store      = $store;
		$this->currencies = $currencies;

        // Loop and assign arguments
        if (is_array($args)) {
            foreach ($args as $key => $value) {
                if (isset($this->data[$key])) $this->data[$key] = $value;
            }
        }

        // Assign base exchange rates
        $this->store->insertUpdate('GBP', 1.00);
        $this->store->insertUpdate('EUR', 1.180573);
        $this->store->insertUpdate('USD', 1.551257);
	}

	public function update()
	{
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
            $new   = $trate * ( 1 / $frate );
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

}
