<?php
require_once '../../Models/UserModel.php';
require_once '../../../helpers/session.php';

class User
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

    //Check for user/email
    if ($this->userModel->findUserByEmailOrUsername($data['username'], $data['username'])) {
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
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //Init data
    $data = [
      'usersName' => trim($_POST['usersName']),
      'usersEmail' => trim($_POST['usersEmail']),
      'usersUid' => trim($_POST['usersUid']),
      'usersPwd' => trim($_POST['usersPwd']),
      'pwdRepeat' => trim($_POST['pwdRepeat'])
    ];

    //Validate inputs
    if (
      empty($data['usersName']) || empty($data['usersEmail']) || empty($data['usersUid']) ||
      empty($data['usersPwd']) || empty($data['pwdRepeat'])
    ) {
      flash("register", "Please fill out all inputs");
      redirect("../signup.php");
    }

    if (!preg_match("/^[a-zA-Z0-9]*$/", $data['usersUid'])) {
      flash("register", "Invalid username");
      redirect("../signup.php");
    }

    if (!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)) {
      flash("register", "Invalid email");
      redirect("../signup.php");
    }

    if (strlen($data['usersPwd']) < 6) {
      flash("register", "Invalid password");
      redirect("../signup.php");
    } else if ($data['usersPwd'] !== $data['pwdRepeat']) {
      flash("register", "Passwords don't match");
      redirect("../signup.php");
    }

    //User with the same email or password already exists
    if ($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])) {
      flash("register", "Username or email already taken");
      redirect("register");
    }

    //Passed all validation checks.
    //Now going to hash password
    $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

    //Register User
    if ($this->userModel->register($data)) {
      redirect("login");
    } else {
      die("Something went wrong");
    }
  }

  public function createUserSession($user)
  {
    $_SESSION['name'] = $user->name;
    // $_SESSION['usersEmail'] = $user->usersEmail;
    if ($user->user_type == 'admin') {
      $_SESSION['admin'] = true;
      redirect("admin");
    } else {
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

$init = new User;

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
