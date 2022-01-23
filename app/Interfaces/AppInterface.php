<?php

namespace App\Interfaces;

interface AppInterface
{
    public function getAll();

    public function findById($id);

    public function create($request);

    public function update($request, $id);
    
    public function delete($id);

    public function getNextNumber($value);

    public function getById($value);
}
