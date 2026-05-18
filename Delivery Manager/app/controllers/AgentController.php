<?php

class AgentController extends Controller
{
    private $agentModel;

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

        $this->agentModel =
            $this->model('AgentModel');
    }

    /* =========================
    ALL AGENTS
    ========================= */

    public function index()
    {
        $filter =
            $_GET['status'] ?? 'all';

        $data = [

            'agents' =>
                $this->agentModel
                ->getAllAgents($filter),

            'filter' => $filter
        ];

        $this->view(
            'agents/index',
            $data
        );
    }

    /* =========================
    ADD AGENT
    ========================= */

    public function create()
    {
        $data = [

            'success' => '',
            'error' => ''

        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $name =
                trim($_POST['name']);

            $email =
                trim($_POST['email']);

            $phone =
                trim($_POST['phone']);

            $vehicle =
                trim($_POST['vehicle']);

            $password =
                trim($_POST['password']);

            if(
                !preg_match(
                    "/^[a-zA-Z ]+$/",
                    $name
                )
            )
            {
                $data['error'] =
                    'Name can only contain letters and spaces';
            }

            elseif(
                strlen($phone) != 11
                ||
                !ctype_digit($phone)
            )
            {
                $data['error'] =
                    'Phone number must be exactly 11 digits';
            }

            else
            {
                $result =
                    $this->agentModel
                    ->addAgent(
                        $name,
                        $email,
                        $phone,
                        $vehicle,
                        $password
                    );

                if($result === true)
                {
                    $data['success'] =
                        'Delivery Agent Added Successfully';
                }
                else
                {
                    $data['error'] =
                        $result;
                }
            }
        }

        $this->view(
            'agents/create',
            $data
        );
    }

    /* =========================
    EDIT AGENT
    ========================= */

    public function edit()
    {
        $id = $_GET['id'];

        $agent =
            $this->agentModel
            ->getAgentById($id);

        if(isset($_POST['update']))
        {
            $name =
                $_POST['name'];

            $email =
                $_POST['email'];

            $phone =
                $_POST['phone'];

            $vehicle =
                $_POST['vehicle'];

            $this->agentModel
                ->updateAgent(
                    $id,
                    $agent['user_id'],
                    $name,
                    $email,
                    $phone,
                    $vehicle
                );

            header(
                "Location: " .
                BASE_URL .
                "/?url=manage-agents"
            );

            exit();
        }

        $data = [
            'agent' => $agent
        ];

        $this->view(
            'agents/edit',
            $data
        );
    }

    /* =========================
    DELETE AGENT
    ========================= */

    public function delete()
    {
        $id = $_GET['id'];

        $this->agentModel
            ->deleteAgent($id);

        header(
            "Location: " .
            BASE_URL .
            "/?url=manage-agents"
        );

        exit();
    }

    /* =========================
    TOGGLE AGENT
    ========================= */

    public function toggle()
    {
        $id = $_GET['id'];

        $status =
            $_GET['status'];

        $this->agentModel
            ->toggleAgent(
                $id,
                $status
            );

        header(
            "Location: " .
            BASE_URL .
            "/?url=manage-agents"
        );

        exit();
    }
}

?>