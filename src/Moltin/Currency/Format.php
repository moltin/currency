<?php namespace Moltin\Currency;

class Format
{

	public function formatCurrency()
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

}
