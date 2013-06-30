<?php

/**
 * This file is part of Moltin Currency, a PHP library to process, format and
 * convert values between various currencies and formats.
 *
 * Copyright (c) 2013 Moltin Ltd.
 * http://github.com/moltin/currency
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package moltin/currency
 * @author Jamie Holdroyd <jamie@molt.in>
 * @copyright 2013 Moltin Ltd.
 * @version dev
 * @link http://github.com/moltin/currency
 *
 */

namespace Moltin\Currency\Storage;

use Moltin\Currency\Exception\StorageException;

class Session implements \Moltin\Currency\StorageInterface
{
    
    public function __construct($args = array())
    {
        session_id() or session_start();

        // Create default item
        if ( ! isset($_SESSION['currency'])) {
            $_SESSION['currency'] = array();
        }
    }

    public function get($code)
    {
        // Not found
    	if ( ! isset($_SESSION['currency'][$code])) {
            return;
        }

        return $_SESSION['currency'][$code];
    }

    public function insertUpdate($code, $data)
    {
        $_SESSION['currency'][$code] = $data;

        return $this;
    }

    public function remove($id)
    {
    	unset($_SESSION['currency'][$code]);

        return $this;
    }

}
