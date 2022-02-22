<?php

namespace App\Core\Interfaces\Advance;

interface ReleaseInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

    public function getNextNumber($value);

    public function getById($value);
}
