<?php

namespace App\Core\Interfaces\Accounting;

interface CashBankInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

    public function getNextNumber($value, $tipeID);

    public function getById($value);
}
