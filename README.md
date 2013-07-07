# Currency Package

[![Build Status](https://secure.travis-ci.org/moltin/currency.png)](http://travis-ci.org/moltin/currency)

* [Website](http://molt.in)
* [License](https://github.com/moltin/currency/master/LICENSE)
* Version: dev

The Moltin currency composer package makes it easy to implement multi-currency pricing into your application and
store the exchange data using one of the numerous data stores provided. You can also inject your own data store if you
would like your data to be stored elsewhere.

## Installation
Download and install composer from `http://www.getcomposer.org/download`

Add the following to your project `composer.json` file
```
{
    "require": {
        "moltin/currency": "dev-master"
    }
}
```
When you're done just run `php composer.phar install` and the package is ready to be used.

## Usage
Below is a basic usage guide for this package.

### Instantiating currency
Before you begin, you will need to know which storage, currencies and exchange method you are going to use. The exchange method
defines where your exchange rates are retrieved from. The currencies method is used to retrieve your supported currencies
for the current application.

In this example we're going to use the currencies file, exchange file and session for storage.

```php
use Moltin\Currency\Currency as Currency;
use Moltin\Currency\Format\Runtime as RuntimeFormat;
use Moltin\Currency\Exchange\OpenExchangeRates as OpenExchange;

$currency = new Currency(new OpenExchange($app_id), new RuntimeFormat);
```

### Setting the value
Now that you have Currency instantiated, you will now need to tell it what value you would like to convert.
You can do this using the following method.

```php
$currency->convert(9.33)->from('GBP');
```

### Getting the value
The most basic action you can perform is rertieve the original value back from the method.

```php
// Returns 9.33
$value = $currency->value();
```

### Formatting as a currency
By default the currency is set to GBP so calling currency will format the value to a string with £ and correct
decimal and thousand seperators.

```php
// Returns £9.33
$value = $currency->format();
```

### Rounding to common values
There are a number of common pricing formats built in to make "nice" prices easy to implement. These
formats changes the default value and return the object to allow for chaining.

```php
// Sets value to 10.00
$currency->zeros();

// Sets value to 9.99
$currency->nines();

// Sets value to 9.50
$currency->fifty();

// Returns £9.50
$value = $currency->fifty()->format();
```

### Currency Exchange
The package makes it as easy as possible to quickly switch between currencies. Before each exchange the value
is reset to default to ensure the correct price is assigned.

```php
// Returns ~$14.47
$value = $currency->convert(9.33)->from('GBP')->to('USD')->format();

// Returns ~14.50
$value = $currency->convert(9.33)->from('GBP')->to('USD')->fifty()->value();
```

### Resetting the value
After using exchange or any of the rounding functions to retrieve the default value you must call reset.

```php
// Returns 10.00
$value = $currency->zeros()->value();

// Returns 9.33
$value = $currency->reset()->value();
```
