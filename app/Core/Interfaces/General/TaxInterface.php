<?php

namespace App\Core\Interfaces\General;

interface TaxInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

}
