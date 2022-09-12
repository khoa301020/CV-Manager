<?php
require_once 'C:/xampp/htdocs/CV-Manager/database/Database.php';
require_once 'C:/xampp/htdocs/CV-Manager/app/Models/InterviewModel.php';

class CVModel
{
  private $db;
  private $interviewModel;

  public function __construct()
  {
    $this->db = new Database();
    $this->interviewModel = new InterviewModel();
  }

  //Get all CVs
  public function getAllCVs()
  {
    $this->db->query('SELECT * FROM cv');

    $results = $this->db->resultSet();

    return $results;
  }

  //Get CVs by status
  public function getCVsByStatus($status)
  {
    $this->db->query('SELECT * FROM cv WHERE review_status = :status');
    $this->db->bind(':status', $status);

    $results = $this->db->resultSet();

    return $results;
  }

  //Get all CVs from user
  public function getAllCVsFromUser($username)
  {
    $this->db->query('SELECT * FROM cv WHERE username = :username');
    $this->db->bind(':username', $username);

    $results = $this->db->resultSet();

    return $results;
  }

  //Get CVs count
  public function getCVCount()
  {
    $this->db->query('SELECT * FROM cv');

    return $this->db->rowCount();
  }

  //Check if CV has review_status = "Pending" exists
  public function checkIfPendingCVExists($user_id)
  {
    $this->db->query('SELECT * FROM cv WHERE user_id = :user_id AND review_status = "Pending"');
    $this->db->bind(':user_id', $user_id);

    $row = $this->db->single();

    //Check row
    if ($row) {
      return true;
    } else {
      return false;
    }
  }

  //Send CV 
  public function sendCV($data)
  {
    $this->db->query('INSERT INTO cv (user_id, position_id, cv_file) 
    VALUES (:user_id, :position_id, :cv_file)');
    //Bind values
    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':position_id', $data['position_id']);
    $this->db->bind(':cv_file', $data['cv_file']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  //Set review status to "Approved" and handled_at to current time
  public function approveCV($cv_id)
  {
    $this->db->query('UPDATE cv SET review_status = "Approved", handled_at = CURRENT_TIMESTAMP WHERE cv_id = :cv_id');
    $this->db->bind(':cv_id', $cv_id);

    $this->db->execute();

    // Create interview
    $this->interviewModel->createInterview($cv_id);
  }

  //Set review status to "Rejected" and handled_at to current time
  public function rejectCV($cv_id)
  {
    $this->db->query('UPDATE cv SET review_status = "Rejected", handled_at = CURRENT_TIMESTAMP WHERE cv_id = :cv_id');
    $this->db->bind(':cv_id', $cv_id);

    $this->db->execute();
  }

  // Save CV  file in resources/cv
  public function saveCVFile()
  {
    $target_dir = "../../../resources/cv/";
    $target_file = $target_dir . basename($_FILES["cv_file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["cv_file"]["size"] > 4000000) {
      flash("Sorry, your file is too large.");
      $uploadOk = 0;
    }

    // Allow certain file formats
    if (
      $imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png"
    ) {
      flash("Sorry, only JPG, JPEG & PNG files are allowed.");
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      flash("Sorry, your file was not uploaded.");
      // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["cv_file"]["tmp_name"], $target_file)) {
        flash("The file " . htmlspecialchars(basename($_FILES["cv_file"]["name"])) . " has been uploaded.");
        flash($target_file);
        return $target_file;
      } else {
        flash("Sorry, there was an error uploading your file.");
      }
    }
  }
}
