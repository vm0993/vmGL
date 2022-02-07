<?php

namespace App\Interfaces;

interface NumberFormatingInterface extends AppInterface
{
    public function getNextNumber($value);

    public function getById($value);
}