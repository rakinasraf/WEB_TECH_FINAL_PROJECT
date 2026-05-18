<?php

class DashboardController extends Controller
{
    private $dashboardModel;

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

        $this->dashboardModel =
            $this->model('DashboardModel');
    }

    public function index()
    {
        $managerId = $_SESSION['manager_id'];

        $data = [

            'profile_image' =>
                $this->dashboardModel
                ->getProfileImage($managerId),

            'pending' =>
                $this->dashboardModel
                ->pendingOrders(),

            'active' =>
                $this->dashboardModel
                ->activeDeliveries(),

            'today' =>
                $this->dashboardModel
                ->deliveredToday()
        ];

        $this->view('dashboard/index', $data);
    }
}

?>