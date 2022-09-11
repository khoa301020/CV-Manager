<?php
require_once '../../Models/CVModel.php';
require_once '../../../helpers/session.php';

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
      'cv_file' => trim($_POST['cv_file']),
    ];

    //Send CV
    if ($this->CVModel->sendCV($data)) {
      flash("CV sent successfully", "alert alert-success");
      redirect("success");
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
}

$init = new CVController;

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch ($_POST['type']) {
    case 'sendCV':
      $init->sendCV();
      break;
    default:
      redirect("");
  }
}
// else {
//   switch ($_GET['q']) {
//     case 'approveCV':
//       $init->approveCV($_GET['id']);
//       break;
//     default:
//       redirect("");
//   }
// }
