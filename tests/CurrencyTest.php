<?php

use Moltin\Currency\Currency;
use Moltin\Currency\Storage\Session as SessionStore;
use Moltin\Currency\Currencies\File as FileCurrencies;
use Moltin\Currency\Exchange\File as FileExchange;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    protected $exchagnge;
    protected $tests = 100;
    protected $start = 1;       // £0.01
    protected $end   = 1000000; // £10,000.00

    public function setUp()
    {
        $this->exchange = new FileExchange(new SessionStore, new FileCurrencies, array('base' => 'GBP', 'app_id' => ''));
    }

    public function tearDown()
    {
        $this->exchange = null;
    }

    # Format
    public function testValue()
    {
        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new Currency($this->exchange);

            // Assert it
            $this->assertEquals($value, $currency->convert($value)->value());
        }
    }

    public function testCurrency()
    {
        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new Currency($this->exchange);

            // Assert it
            $this->assertEquals('&pound;'.number_format($value, 2), $currency->convert($value)->format());
        }
    }

}
