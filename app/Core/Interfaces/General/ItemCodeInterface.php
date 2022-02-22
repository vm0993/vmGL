<?php

namespace App\Core\Interfaces\General;

interface ItemCodeInterface extends ItemInterface
{
    public function getNextNumber($value);

    public function getById($value);
}