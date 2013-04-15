<?php namespace Moltin\Currency;

class Format
{

	public function raw()
	{
		return $this->get('value');
	}

	public function currency()
	{

		// Variables
		$value    = $this->get('value');
		$format   = $this->get('format');
		$decimal  = $this->get('decimal');
		$thousand = $this->get('thousand');

		// Format
		$formatted = number_format($value, 2, $decimal, $thousand);
		$formatted = str_replace('{price}', $formatted, $format);

		return $formatted;
	}

	public function zeros()
	{

		// Variables
		$value    = $this->get('value');
		$decimal  = $this->get('decimal');

		// Format
		$formatted = ceil($value).$decimal.'00';
		$formatted = number_format($value, 2, $decimal, false);

		return $formatted;
	}

	public function nines()
	{

		// Variables
		$value    = $this->get('value');
		$decimal  = $this->get('decimal');

		// Format
		$formatted = ceil($value) - 0.01;
		$formatted = number_format($value, 2, $decimal, false);

		return $formatted;
	}

	public function fifty()
	{

		// Variables
		$value    = $this->get('value');
		$decimal  = $this->get('decimal');

		// Format
		$formatted = ( round(( $value * 2 ), 0) / 2 );
		$formatted = number_format($value, 2, $decimal, false);

		return $formatted;
	}

}
