<?php

require_once '../../Models/UserModel.php';
require_once '../../../helpers/session.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        //Init data
        $data = [
        'username' => trim($_POST['username']),
        'password' => trim($_POST['password'])
        ];

        //Check for user/email/phone
        if ($this->userModel->findUserByEmailOrUsernameOrPhone($data['username'], $data['username'], $data['username'])) {
            //User Found
            $loggedInUser = $this->userModel->login($data['username'], $data['password']);
            if ($loggedInUser) {
                //Create session
                $this->createUserSession($loggedInUser);
            } else {
                flash("Password Incorrect");
                redirect("login");
            }
        } else {
            flash("No user found");
            redirect("login");
        }
    }

    public function register()
    {
        //Process form

        //Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

        //Init data
        $data = [
        'username' => trim($_POST['username']),
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'gender' => trim($_POST['gender']),
        'phone_number' => trim($_POST['phone']),
        'password' => trim($_POST['pass']),
        ];

        // Check email/username exists
        if ($this->userModel->findUserByEmailOrUsernameOrPhone($data['username'], $data['email'], $data['phone_number'])) {
            flash("Username or email or phone number already taken");
            redirect("register");
        }

        //Passed all validation checks.
        //Now going to hash password if pass_confirm == pass
        if ($data['password'] === $_POST['pass_confirm']) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            flash("Password does not match");
            redirect("register");
        }

        //Register User
        if ($this->userModel->register($data)) {
            redirect("login");
        } else {
            die("Something went wrong");
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['name'] = $user->name;
        $_SESSION['userEmail'] = $user->email;
        if ($user->user_type == 'admin') {
            $_SESSION['admin'] = true;
            redirect("admin");
        } else {
            $_SESSION['user'] = true;
            redirect("apply");
        }
    }

    public function logout()
    {
        unset($_SESSION['name']);
        // unset($_SESSION['usersEmail']);
        session_destroy();
        redirect("");
    }
}

$init = new UserController();

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'register':
            $init->register();
            break;
        case 'login':
            $init->login();
            break;
        default:
            redirect("");
    }
} else {
    switch ($_GET['q']) {
        case 'logout':
            $init->logout();
            break;
        default:
            redirect("");
    }
}
