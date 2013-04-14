<?php namespace Moltin\Currency;

// interface StorageInterface
class StorageInterface
{
    public function get($code)
	{

		$data = array(
			'format'   => '&pound;{price}',
			'decimal'  => '.',
			'thousand' => ','
		);

		return $data;
	}

	public function insertUpdate($id, $data) {}
    
    public function remove($id) {}
    
    public function setIdentifier($identifier) {}
    
    public function getIdentifier($identifier) {}
}