<?php

require_once './MailController.php';
require_once '../../Models/UserModel.php';
require_once '../../Models/ResetPasswordModel.php';
require_once '../../../helpers/session.php';

class ResetPasswordController
{
    private $ResetPasswordModel;
    private $UserModel;

    public function __construct()
    {
        $this->ResetPasswordModel = new ResetPasswordModel();
        $this->UserModel = new UserModel();
    }


    public function sendResetMail()
    {
        //Validate username, email & phone number correct
        $user = [
        'email' => trim($_POST['email']),
        'username' => trim($_POST['username']),
        'phone' => trim($_POST['phone']),
        ];

        if ($this->UserModel->findUserByEmailOrUsernameOrPhone($user['email'], $user['username'], $user['phone'])) {
            //User Found
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $url = "http://cvmanager.test/new-password?selector=" . $selector . "&validator=" . bin2hex($token);
            //expires after 30 min
            $expires = date("Y-m-d H:i:s", time() + 1800);

            //Mail data
            $mailData = [
            'userEmail' => $user['email'],
            'subject' => "Reset password request",
            'message' => "Your reset link: " . $url,
            ];

            $mailController = new MailController();
            $mailController->sendMail($mailData);

            //Add token to database
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            $this->ResetPasswordModel->createResetPasswordToken($selector, $hashedToken, $user['email'], $expires);

            //Redirect to login page
            redirect('login');
        }
    }

    public function resetPassword($selector, $validation)
    {
        //Validate selector & validation
        if (empty($selector) || empty($validation)) {
            redirect("");
            exit();
        }

        //Check if token is valid
        if ($this->ResetPasswordModel->checkToken($selector, $validation)) {
            //Token is valid
            $email = $this->ResetPasswordModel->checkToken($selector, $validation);
            $password = trim($_POST['pass']);
            $passwordRepeat = trim($_POST['pass-confirm']);

            //Validate password
            if ($password === $passwordRepeat) {
                //Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                //Update password
                if ($this->ResetPasswordModel->updatePassword($hashedPassword, $email)) {
                    //Send mail
                    $mailData = [
                    'userEmail' => $email,
                    'subject' => "Password reset",
                    'message' => "Your password has been reset.",
                    ];

                    $mailController = new MailController();
                    $mailController->sendMail($mailData);

                    redirect("login");
                } else {
                    die('Something went wrong');
                }
            }
        }
    }
}

$init = new ResetPasswordController();

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    switch ($_POST['type']) {
        case 'sendResetMail':
            $init->sendResetMail();
            break;
        case 'resetPassword':
            $init->resetPassword($_POST['selector'], $_POST['validator']);
            break;
        default:
            redirect("");
    }
}
