<?php

namespace App\Core\Interfaces\Advance;

interface ApproveRequestInterface extends ApprovalInterface
{
    public function approveRequest($id);

    public function previewApproveRequestForm($id);

}