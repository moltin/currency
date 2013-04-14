<?php namespace Moltin\Currency;

class Currency extends Format
{
    protected $store;
	protected $fields = array();

	public function __construct(StorageInterface $store)
	{
		// Set storage interface
        $this->store = $store;

        // Set initial currency
        $this->setCurrency();
    }

	public function setCurrency($code = 'GBP')
	{

		// Get selected currency
		if ( $currency = $this->store->get($code) ) {
			$this->set($currency);
		}

		return $this;
	}

    public function get($property)
    {

    	// Found
        if ( isset($this->fields[$property]) ) {
        	return $this->fields[$property];
        }

        // Nothing found
        return;
    }
       
    public function set($property, $value = null)
    {
    	// Multiple assignments
		if ( is_array($property) ) {

			// Loop and assign
			foreach ( $property as $key => $value ) {
				$this->fields[$key] = $value;
			}

		// Single
		} else {
			$this->fields[$property] = $value;
		}

		return $this;
    }

}
