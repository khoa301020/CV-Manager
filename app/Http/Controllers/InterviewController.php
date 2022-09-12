<?php
// require_once './MailController.php';
require_once '../../Models/InterviewModel.php';
require_once '../../../helpers/session.php';

class InterviewController
{
  private $interviewModel;

  public function __construct()
  {
    $this->interviewModel = new InterviewModel();
  }

  public function acceptInvitation($id)
  {
    //Get current datetime
    $current_datetime = date('Y-m-d H:i:s');
    //Get invitation datetime
    $invitation_datetime = $this->interviewModel->getInterviewInvitationTime($id)[2];
    //Check if current datetime is less 6 hours than invitation datetime
    if (strtotime($current_datetime) < strtotime($invitation_datetime) - 6 * 60 * 60) {
      $this->interviewModel->acceptInterviewInvitation($id);
      redirect("apply");
    } else {
      $this->interviewModel->acceptLateInterviewInvitation($id);
      redirect("apply");
    }
  }

  public function declineInvitation($id)
  {
    $this->interviewModel->declineInterviewInvitation($id);
    redirect("apply");
  }
}

$init = new InterviewController;

//Ensure that user is sending a post request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch ($_POST['type']) {
    case 'acceptInv':
      $init->acceptInvitation($_POST['interview_id']);
      break;
    case 'declineInv':
      $init->declineInvitation($_POST['interview_id']);
      break;
  }
}
