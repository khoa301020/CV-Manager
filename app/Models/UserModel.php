<?php

require_once 'C:/xampp/htdocs/CV-Manager/database/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    //Find user by email or username
    public function findUserByEmailOrUsernameOrPhone($email, $username, $phone)
    {
        $this->db->query('SELECT * FROM user WHERE username = :username OR email = :email OR phone_number = :phone');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);
        $this->db->bind(':phone', $phone);

        $row = $this->db->single();

        //Check row
        if ($this->db->rowCount() > 0) {
            return $row;
        } else {
            return false;
        }
    }

    //Get user by id
    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM user WHERE user_id = :id');
        $this->db->bind(':id', $id);

        $result = $this->db->single();

        return $result;
    }

    //Login user
    public function login($nameOrEmailOrPhone, $password)
    {
        $row = $this->findUserByEmailOrUsernameOrPhone($nameOrEmailOrPhone, $nameOrEmailOrPhone, $nameOrEmailOrPhone);

        if ($row == false) {
            return false;
        }

        $hashedPassword = $row->password;
        if (password_verify($password, $hashedPassword)) {
            return $row;
        } else {
            return false;
        }
    }

    //Register User
    public function register($data)
    {
        $this->db->query(
            'INSERT INTO user (username, name, gender, email, phone_number, password) 
    VALUES (:username, :name, :gender, :email, :phone_number, :password)'
        );
        //Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':password', $data['password']);

        //Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
