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

namespace Moltin\Currency\Currencies;

use Moltin\Currency\Exception\CurrencyException;

class File implements \Moltin\Currency\CurrenciesInterface
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

	public function get($code)
	{
		if ( ! isset($this->available[$code]) ) {
			throw new CurrencyException('Currency ('.$code.') not found');
		}

		return $this->available[$code];
	}

}
