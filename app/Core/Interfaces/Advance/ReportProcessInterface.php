<?php

namespace App\Core\Interfaces\Advance;

interface ReportProcessInterface extends ReportingInterface
{
    public function submitReport($id);

    public function previewReportForm($id);

    public function approveReport($id);

    public function previewApproveReportForm($id);

}
