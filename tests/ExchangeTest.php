<?php

use Moltin\Currency\Currency;
use Moltin\Currency\Format\Runtime as RuntimeFormat;
use Moltin\Currency\Exchange\Runtime as RuntimeExchange;

class ExchangeTest extends \PHPUnit_Framework_TestCase
{

    protected $exchagnge;
    protected $tests = 100;
    protected $start = 1;       // £0.01
    protected $end   = 1000000; // £10,000.00

    public function __construct()
    {
        // Create required objects
        $this->exchange = new RuntimeExchange;
        $this->format   = new RuntimeFormat;

        $this->exchange->add('GBP', 1.00);
        $this->exchange->add('EUR', 1.180573);
        $this->exchange->add('USD', 1.551257); 
    }

    public function testGBPtoUSD()
    {
        // Variables
        $rate = $this->exchange->get('USD');

        // Loop and test
        for ($i = 0; $i < $this->tests; $i++) {

            // Build value
            $value = rand($this->start, $this->end) / 100;

            // Setup
            $currency = new Currency($this->exchange, $this->format);

            // Assert it
            $this->assertEquals($value * $rate, $currency->convert($value)->from('GBP')->to('USD')->value());
        }
    }

    public function testGBPtoUSDCurrency()
    {
        // Variables
        $rate = $this->exchange->get('USD');

        // Loop and test
        for ($i = 0; $i < $this->tests; $i++) {

            // Build value
            $value = rand($this->start, $this->end) / 100;

            // Setup
            $currency = new Currency($this->exchange, new RuntimeFormat);

            // Assert it
            $this->assertEquals('$'.number_format($value * $rate, 2), $currency->convert($value)->from('GBP')->to('USD')->format());
        }
    }

}
