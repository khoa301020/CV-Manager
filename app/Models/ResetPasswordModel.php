<?php

require_once 'C:/xampp/htdocs/CV-Manager/database/Database.php';

class ResetPasswordModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    //Create reset password token
    public function createResetPasswordToken($selector, $hashedToken, $email, $expires)
    {
        $this->db->query('INSERT INTO resetpassword (reset_email, reset_selector, reset_token, expires_at) VALUES (:email, :selector, :token, :expires)');
        $this->db->bind(':email', $email);
        $this->db->bind(':selector', $selector);
        $this->db->bind(':token', $hashedToken);
        $this->db->bind(':expires', $expires);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Check if token is valid
    public function checkToken($selector, $validator)
    {
        $this->db->query('SELECT * FROM resetpassword WHERE reset_selector = :selector AND expires_at >= :expires');
        $this->db->bind(':selector', $selector);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->db->bind(':expires', date('Y-m-d H:i:s'));

        $row = $this->db->single();

        if ($this->db->rowCount() > 0) {
            $tokenBin = hex2bin($validator);
            $tokenCheck = password_verify($tokenBin, $row->reset_token);

            if ($tokenCheck) {
                return $row->reset_email;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //Delete token
    // public function deleteToken($email)
    // {
    //   $this->db->query('DELETE FROM resetpassword WHERE reset_email = :email');
    //   $this->db->bind(':email', $email);

    //   if ($this->db->execute()) {
    //     return true;
    //   } else {
    //     return false;
    //   }
    // }

    //Reset/Update password
    public function updatePassword($password, $email)
    {
        $this->db->query('UPDATE user SET password = :password WHERE email = :email');
        $this->db->bind(':password', $password);
        $this->db->bind(':email', $email);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
