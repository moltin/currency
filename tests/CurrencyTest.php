<?php

use Moltin\Currency\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    protected $start = 1;      // £0.01
    protected $end   = 350000; // £3,500.00

    # Format
    public function testValue()
    {
        // Loop and test
        for ( $value = $this->start; $value <= $this->end; $value++ ) {

            // Setup
            $currency = new \Moltin\Currency\Currency(array('value' => $value));

            // Assert it
            $this->assertEquals($value, $currency->value());
        }
    }

    public function testCurrency()
    {
        // Loop and test
        for ( $value = $this->start; $value <= $this->end; $value++ ) {

            // Setup
            $currency = new \Moltin\Currency\Currency(array('value' => $value));

            // Assert it
            $this->assertEquals('&pound;'.number_format($value, 2), $currency->currency());
        }
    }

}
