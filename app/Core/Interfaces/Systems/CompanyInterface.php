<?php

namespace App\Core\Interfaces\Systems;

interface CompanyInterface
{
    public function findFirstRecord();

    public function create($request);

    public function update($request, $id);
    
}
