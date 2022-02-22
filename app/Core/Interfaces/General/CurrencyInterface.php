<?php

namespace App\Core\Interfaces\General;

interface CurrencyInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

}
