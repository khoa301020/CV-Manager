<?php
// PHP Mailer
require_once '../../../helpers/PHPMailer/src/PHPMailer.php';
require_once '../../../helpers/PHPMailer/src/SMTP.php';
require_once '../../../helpers/PHPMailer/src/Exception.php';

class MailController
{
  private $mail;

  public function __construct()
  {
    $this->mail = new PHPMailer\PHPMailer\PHPMailer();
  }

  public function sendMail($data)
  {
    //Server settings
    $this->mail->isSMTP();
    $this->mail->SMTPAuth   = true;
    $this->mail->Host       = 'smtp.mailtrap.io';
    $this->mail->Port       = 2525;
    $this->mail->Username   = '9f76d81a47f998';
    $this->mail->Password   = '2f781ede490b7a';

    //Mail data
    $this->mail->setFrom('MOR-Software@mor.vn', 'MOR Software');
    $this->mail->isHTML(true);
    $this->mail->Subject = $data['subject'];
    $this->mail->Body = $data['message'];
    flash($data['userEmail']);
    $this->mail->addAddress($data['userEmail']);

    //Send mail
    if ($this->mail->send()) {
      return true;
    } else {
      flash($this->mail->ErrorInfo . "\n");
      return false;
    }
  }
}
