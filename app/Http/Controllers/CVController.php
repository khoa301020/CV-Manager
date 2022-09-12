<?php
require_once '../../Models/CVModel.php';
require_once '../../../helpers/session.php';
require_once './MailController.php';

class CVController
{
  private $userModel;

  public function __construct()
  {
    $this->CVModel = new CVModel();
  }

  public function sendCV()
  {
    //Init data
    $data = [
      'user_id' => trim($_SESSION['user_id']),
      'position_id' => trim($_POST['position']),
      'cv_file' => trim($this->CVModel->saveCVFile()),
    ];

    //Send CV
    if ($this->CVModel->sendCV($data)) {
      //Automail data
      $automailData = [
        'userEmail' => $_SESSION['userEmail'],
        'subject' => "[Automail] CV received",
        'message' => "Your CV has been received. We will contact you soon.",
      ];

      //Send Received Email
      $mailController = new MailController();
      if ($mailController->sendMail($automailData)) {
        flash("CV sent successfully");
        redirect("success");
      } else {
        flash("CV sent successfully but email not sent");
        redirect("fail");
      }
    } else {
      flash("Something went wrong");
      redirect("fail");
    }
  }

  //Approve CV
  public function approveCV($id)
  {
    //Init data
    $data = [
      'id' => $id,
      'review_status' => "Approved"
    ];

    //Approve CV
    if ($this->CVModel->approveCV($data)) {
      redirect("apply");
    } else {
      redirect("apply");
    }
  }

  // Show all CV by status
  public function showCVByStatus($status)
  {
    $data = $this->CVModel->showCVByStatus($status);
    return $data;
  }
}

$init = new CVController;

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch ($_POST['type']) {
    case 'sendCV':
      $init->sendCV();
      break;
    case 'acceptCV':
      $init->approveCV($_POST['id']);
      break;
    default:
      redirect("");
  }
} else {
  switch ($_GET['status']) {
    case 'approveCV':
      $init->approveCV($_GET['id']);
      break;
    default:
      redirect("");
  }
}
