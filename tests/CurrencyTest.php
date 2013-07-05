<?php

use Moltin\Currency\Currency;
use Moltin\Currency\Format\Runtime as RuntimeFormat;
use Moltin\Currency\Exchange\Runtime as RuntimeExchange;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    protected $exchagnge;
    protected $tests = 100;
    protected $start = 1;       // £0.01
    protected $end   = 1000000; // £10,000.00

    public function setUp()
    {
        $this->exchange = new RuntimeExchange;
        $this->format   = new RuntimeFormat;
    }

    public function tearDown()
    {
        $this->exchange = null;
    }

    # Format
    public function testValue()
    {
        // Loop and test
        for ($i = 0; $i < $this->tests; $i++) {

            // Build value
            $value = rand($this->start, $this->end) / 100;

            // Setup
            $currency = new Currency($this->exchange, $this->format);

            // Assert it
            $this->assertEquals($value, $currency->convert($value)->value());
        }
    }

    public function testCurrency()
    {
        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = rand($this->start, $this->end) / 100;

            // Setup
            $currency = new Currency($this->exchange, new RuntimeFormat);

            // Assert it
            $this->assertEquals('&pound;'.number_format($value, 2), $currency->convert($value)->format());
        }
    }

}
