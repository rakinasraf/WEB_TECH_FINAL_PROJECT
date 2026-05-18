<?php

class ZoneController extends Controller
{
    private $zoneModel;

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

        $this->zoneModel =
            $this->model('ZoneModel');
    }

    /* =========================
    ALL ZONES
    ========================= */

    public function index()
    {
        $data = [

            'zones' =>
                $this->zoneModel
                ->getAllZones()

        ];

        $this->view(
            'zones/index',
            $data
        );
    }

    /* =========================
    ADD ZONE
    ========================= */

    public function create()
    {
        $data = [

            'success' => ''

        ];

        if(isset($_POST['add']))
        {
            $zone =
                $_POST['zone'];

            $fee =
                $_POST['fee'];

            $days =
                $_POST['days'];

            $result =
                $this->zoneModel
                ->addZone(
                    $zone,
                    $fee,
                    $days
                );

            if($result === true)
            {
                $data['success'] =
                    'Zone Added Successfully';
            }
            else
            {
                $data['success'] =
                    $result;
            }
        }

        $this->view(
            'zones/create',
            $data
        );
    }

    /* =========================
    EDIT ZONE
    ========================= */

    public function edit()
    {
        $id = $_GET['id'];

        $zone =
            $this->zoneModel
            ->getZoneById($id);

        if(isset($_POST['edit']))
        {
            $zoneName =
                $_POST['zone'];

            $fee =
                $_POST['fee'];

            $days =
                $_POST['days'];

            $this->zoneModel
                ->updateZone(
                    $id,
                    $zoneName,
                    $fee,
                    $days
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=manage-zones"
            );

            exit();
        }

        $data = [

            'zone' => $zone

        ];

        $this->view(
            'zones/edit',
            $data
        );
    }

    /* =========================
    DELETE ZONE
    ========================= */

    public function delete()
    {
        $id = $_GET['id'];

        $this->zoneModel
            ->deleteZone($id);

        $_SESSION['success'] =
            'Zone deleted successfully';

        header(
            "Location: " .
            BASE_URL .
            "/?url=manage-zones"
        );

        exit();
    }
}

?>