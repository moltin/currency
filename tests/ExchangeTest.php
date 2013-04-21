<?php

use Moltin\Currency\Currency;

class ExchangeTest extends \PHPUnit_Framework_TestCase
{

    protected $exchagnge;
    protected $tests = 100;
    protected $start = 1;       // £0.01
    protected $end   = 1000000; // £10,000.00

    public function __construct()
    {
        // Create required objects
        $store          = new \Moltin\Currency\Storage\Session();
        $currencies     = new \Moltin\Currency\Currencies\File();
        $this->exchange = new \Moltin\Currency\Exchange\OpenExchangeRates($store, $currencies, array('base' => 'GBP', 'app_id' => '8fc03975a2324ca4b20cae70e987b706'));

        // Pull down rates
        $this->exchange->update();
    }

    public function testGBPtoUSD()
    {
        // Variables
        $rate = $this->exchange->get('USD');

        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new \Moltin\Currency\Currency($this->exchange, $value);

            // Assert it
            $this->assertEquals(( $value * $rate ), $currency->convert('USD')->value());
        }
    }

    public function testGBPtoUSDCurrency()
    {
        // Variables
        $rate = $this->exchange->get('USD');

        // Loop and test
        for ( $i = 0; $i < $this->tests; $i++ ) {

            // Build value
            $value = ( rand($this->start, $this->end) / 100 );

            // Setup
            $currency = new \Moltin\Currency\Currency($this->exchange, $value);

            // Assert it
            $this->assertEquals('$'.number_format(( $value * $rate ), 2), $currency->convert('USD')->currency());
        }
    }

}
