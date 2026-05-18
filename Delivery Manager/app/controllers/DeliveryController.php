<?php

class DeliveryController extends Controller
{
    private $deliveryModel;

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

        $this->deliveryModel =
            $this->model('DeliveryModel');
    }

    /* =========================
    READY ORDERS
    ========================= */

    public function readyOrders()
    {
        $data = [

            'orders' =>
            $this->deliveryModel
            ->getReadyOrders()

        ];

        $this->view(
            'deliveries/ready_orders',
            $data
        );
    }

    /* =========================
    ASSIGN ORDER
    ========================= */

    public function assignOrder()
    {
        $order_id =
            intval($_GET['id']);

        $data = [

            'agents' =>
            $this->deliveryModel
            ->getActiveAgents(),

            'order_id' =>
            $order_id
        ];

        if(isset($_POST['assign']))
        {
            $agent_id =
                $_POST['agent_id'];

            $this->deliveryModel
                ->assignOrder(
                    $order_id,
                    $agent_id
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=active-deliveries"
            );

            exit();
        }

        $this->view(
            'deliveries/assign_order',
            $data
        );
    }

    /* =========================
    ACTIVE DELIVERIES
    ========================= */

    public function activeDeliveries()
    {
        $data = [

            'deliveries' =>

            $this->deliveryModel
            ->getActiveDeliveries()

        ];

        $this->view(
            'deliveries/active_deliveries',
            $data
        );
    }

    /* =========================
    UPDATE STATUS
    ========================= */

    public function updateStatus()
    {
        $id =
            intval($_GET['id']);

        if(isset($_POST['update']))
        {
            $status =
                $_POST['status'];

            if($status == "Failed")
            {
                header(
                    "Location: " .

                    BASE_URL .

                    "/?url=failed-delivery&id=" .

                    $id
                );

                exit();
            }

            $this->deliveryModel
                ->updateDeliveryStatus(
                    $id,
                    $status
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=active-deliveries"
            );

            exit();
        }

        $this->view(
            'deliveries/update_status'
        );
    }

    /* =========================
    FAILED DELIVERY
    ========================= */

    public function failedDelivery()
    {
        $id =
            intval($_GET['id']);

        if(isset($_POST['submit']))
        {
            $reason =
                $_POST['reason'];

            $this->deliveryModel
                ->failedDelivery(
                    $id,
                    $reason
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=delivery-history"
            );

            exit();
        }

        $this->view(
            'deliveries/failed_delivery'
        );
    }

    /* =========================
    DELIVERY HISTORY
    ========================= */

    public function history()
    {
        $data = [

            'history' =>

            $this->deliveryModel
            ->getDeliveryHistory()

        ];

        $this->view(
            'deliveries/history',
            $data
        );
    }

    /* =========================
    REASSIGN DELIVERY
    ========================= */

    public function reassignDelivery()
    {
        $id =
            intval($_GET['id']);

        $delivery =
            $this->deliveryModel
            ->getDeliveryById($id);

        $current_agent =
            $delivery['agent_id'];

        $data = [

            'agents' =>

            $this->deliveryModel
            ->getReassignAgents(
                $current_agent
            )

        ];

        if(isset($_POST['reassign']))
        {
            $new_agent =
                $_POST['agent_id'];

            $this->deliveryModel
                ->reassignDelivery(
                    $id,
                    $new_agent
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=active-deliveries"
            );

            exit();
        }

        $this->view(
            'deliveries/reassign',
            $data
        );
    }

    /* =========================
    DELIVERY SUMMARY
    ========================= */

    public function summary()
    {
        $data =
            $this->deliveryModel
            ->getSummary();

        $this->view(
            'deliveries/summary',
            $data
        );
    }
}

?>