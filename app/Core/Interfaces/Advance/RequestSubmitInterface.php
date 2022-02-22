<?php

namespace App\Core\Interfaces\Advance;

interface RequestSubmitInterface extends RequestInterface
{
    public function submitRequest($id);

    public function previewRequestForm($id);

}
