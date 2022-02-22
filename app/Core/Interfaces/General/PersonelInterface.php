<?php

namespace App\Core\Interfaces\General;

interface PersonelInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

}
