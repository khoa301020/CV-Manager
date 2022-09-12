<?php
require_once './MailController.php';
require_once '../../Models/CVModel.php';
require_once '../../Models/InterviewModel.php';
require_once '../../../helpers/session.php';

class CVController
{
  private $userModel;

  public function __construct()
  {
    $this->CVModel = new CVModel();
    $this->InterviewModel = new InterviewModel();
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
    $this->CVModel->approveCV($id);

    //Create interview
    $this->InterviewModel->createInterview($id);

    //Create invitation
    $invitationData = [
      'interview_id' => $this->InterviewModel->getLastInsertedInterviewID(),
      'user_id' => $this->CVModel->findUserIdByCVId($id),
      'title' => "Interview Invitation",
      'content' => "You have been invited to an interview. Please accept 6 hours before the destinated time.",
    ];

    $this->InterviewModel->createInvitation($invitationData);

    //Send automail
    $automailData = [
      'userEmail' => $this->CVModel->findUserEmailByCVId($id),
      'subject' => "[Automail] CV approved",
      'message' => "Your CV has been approved. Please confirm your interview time within 2 days.",
    ];
    $mailController = new MailController();
    $mailController->sendMail($automailData);

    redirect("admin");
  }

  //Reject CV
  public function rejectCV($id)
  {
    $this->CVModel->rejectCV($id);

    //Send automail
    $automailData = [
      'userEmail' => $this->CVModel->findUserEmailByCVId($id),
      'subject' => "[Automail] CV rejected",
      'message' => "Your CV has been rejected. Please try again later.",
    ];

    $mailController = new MailController();
    $mailController->sendMail($automailData);

    redirect("admin");
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
    case 'approveCV':
      $init->approveCV($_POST['id']);
      break;
    case 'rejectCV':
      $init->rejectCV($_POST['id']);
      break;
    default:
      redirect("");
  }
}
