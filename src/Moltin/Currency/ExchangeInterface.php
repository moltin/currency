<?php

/**
 *
 */

namespace Moltin\Currency;

interface ExchangeInterface
{
    public function get($code);

    public function insertUpdate($id, $data);

    public function remove($id);

    public function setIdentifier($identifier);

    public function getIdentifier($identifier);
}
