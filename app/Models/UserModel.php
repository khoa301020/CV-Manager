<!-- Create User model known that user has username, password, name, email, phonenumber, gender -->
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
  public function findUserByEmailOrUsername($email, $username)
  {
    $this->db->query('SELECT * FROM user WHERE username = :username OR email = :email');
    $this->db->bind(':username', $username);
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    //Check row
    if ($this->db->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }

  //Login user
  public function login($nameOrEmail, $password)
  {
    $row = $this->findUserByEmailOrUsername($nameOrEmail, $nameOrEmail);

    if ($row == false) return false;

    $hashedPassword = $row->password;
    if ($password == $hashedPassword) {
      return $row;
    } else {
      return false;
    }
  }

  //Register User
  public function register($data)
  {
    $this->db->query('INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) 
    VALUES (:name, :email, :Uid, :password)');
    //Bind values
    $this->db->bind(':name', $data['usersName']);
    $this->db->bind(':email', $data['usersEmail']);
    $this->db->bind(':Uid', $data['usersUid']);
    $this->db->bind(':password', $data['usersPwd']);

    //Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
