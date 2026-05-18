<?php

class ReportController extends Controller
{
    private $reportModel;

    public function __construct()
    {
        if(!isset($_SESSION['manager']))
        {
            header(
                "Location: " .
                BASE_URL .
                "/?url=login"
            );

            exit();
        }

        $this->reportModel =
            $this->model('ReportModel');
    }

    /* =========================
    AGENT REPORT
    ========================= */

    public function agentReport()
    {
        $data = [

            'report' =>

            $this->reportModel
            ->getAgentReport()

        ];

        $this->view(
            'reports/agent_report',
            $data
        );
    }

    /* =========================
    ZONE REPORT
    ========================= */

    public function zoneReport()
    {
        $data = [

            'report' =>

            $this->reportModel
            ->getZoneReport()

        ];

        $this->view(
            'reports/zone_report',
            $data
        );
    }
}

?>