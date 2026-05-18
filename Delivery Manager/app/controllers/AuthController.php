```php
<?php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    public function login()
    {
        if(isset($_SESSION['manager']))
        {
            header(
                "Location: " .
                BASE_URL .
                "/?url=dashboard"
            );

            exit();
        }

        $data = [

            'email' => '',
            'emailErr' => '',
            'passwordErr' => '',
            'error' => ''

        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            /* =========================
            EMAIL VALIDATION
            ========================= */

            if(empty($email))
            {
                $data['emailErr'] =
                    'Email Required';
            }
            elseif(
                !filter_var(
                    $email,
                    FILTER_VALIDATE_EMAIL
                )
            )
            {
                $data['emailErr'] =
                    'Invalid Email Format';
            }

            /* =========================
            PASSWORD VALIDATION
            ========================= */

            if(empty($password))
            {
                $data['passwordErr'] =
                    'Password Required';
            }

            /* =========================
            LOGIN CHECK
            ========================= */

            if(
                empty($data['emailErr']) &&
                empty($data['passwordErr'])
            )
            {
                $user =
                    $this->userModel
                    ->findUserByEmail($email);

                if($user)
                {
                    /* =========================
                    PLAIN PASSWORD CHECK
                    ========================= */

                    if(
                        $user['password_hash']
                        == $password
                    )
                    {
                        $_SESSION['manager'] =
                            $user['name'];

                        $_SESSION['manager_id'] =
                            $user['id'];

                        /* =========================
                        REMEMBER ME
                        ========================= */

                        if(isset($_POST['remember']))
                        {
                            setcookie(
                                'delivery_manager_email',
                                $email,
                                time() + (86400 * 30),
                                '/'
                            );
                        }

                        header(
                            "Location: " .
                            BASE_URL .
                            "/?url=dashboard"
                        );

                        exit();
                    }
                    else
                    {
                        $data['error'] =
                            'Incorrect Password';
                    }
                }
                else
                {
                    $data['error'] =
                        'Email Not Found';
                }
            }

            $data['email'] = $email;
        }

        $this->view(
            'auth/login',
            $data
        );
    }

    public function logout()
    {
        session_destroy();

        header(
            "Location: " .
            BASE_URL .
            "/?url=login"
        );

        exit();
    }
}

?>
```
