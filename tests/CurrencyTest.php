<?php

use Moltin\Currency\Currency;

class CurrencyTest extends \PHPUnit_Framework_TestCase
{

    protected $currency;

    /**
     * @covers Order::__construct
     */
    public function __construct()
    {
        // Setup storage interface
        $storage = new \Moltin\Currency\StorageInterface();

        // Spawn order
        $this->currency = new \Moltin\Currency\Currency($storage);
    }

    # Format

    public function testFormatCurrency()
    {

        // Options
        $start = 1;       // £0.01
        $end   = 1000000; // £10,000.00

        // Set to GBP
        $this->currency->setCurrency('GBP');

        // Loop
        for ( $i = $start; $i <= $end; $i++ ) {

            // Variables
            $base      = ( $i / 100 );
            $formatted = $this->currency->set('value', $base)
                                        ->formatCurrency();

            // Assert it
            $this->assertEquals('&pound;'.number_format($base, 2), $formatted);
        }

    }

}
