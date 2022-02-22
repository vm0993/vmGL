<?php

namespace App\Core\Interfaces\Advance;

interface ReleaseRequestInterface extends ReleaseInterface
{
    public function releaseRequest($id);

    public function previewReleaseRequestForm($id);

}
