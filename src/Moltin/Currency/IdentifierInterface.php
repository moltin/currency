<?php namespace Moltin\Currency;

interface IdentifierInterface
{
    public function getIdentifier($id, $data);

    public function regenerate();
}