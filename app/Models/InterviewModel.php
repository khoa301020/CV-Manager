<?php

require_once 'C:/xampp/htdocs/CV-Manager/database/Database.php';

class InterviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    //Get all interviews
    public function getAllInterviews()
    {
        $this->db->query('SELECT * FROM interview');

        $results = $this->db->resultSet();

        return $results;
    }

    //Get all interviews from user
    public function getAllInterviewsFromUser($username)
    {
        $this->db->query('SELECT * FROM interview WHERE username = :username');
        $this->db->bind(':username', $username);

        $results = $this->db->resultSet();

        return $results;
    }

    //Create Interview with interview day = current datetime + 2 days
    public function createInterview($cv_id)
    {
        $this->db->query(
            'INSERT INTO interview (cv_id, interview_date) 
    VALUES (:cv_id, CURRENT_TIMESTAMP + INTERVAL 2 DAY)'
        );
        //Bind values
        $this->db->bind(':cv_id', $cv_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Get the last inserted Interview ID
    public function getLastInsertedInterviewID()
    {
        return $this->db->lastInsertId();
    }

    //Create Invitation
    public function createInvitation($data)
    {
        $this->db->query(
            'INSERT INTO interviewinvitation (interview_id, user_id, invitation_title, invitation_content) 
    VALUES (:interview_id, :user_id, :title, :content)'
        );
        //Bind values
        $this->db->bind(':interview_id', $data['interview_id']);
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':content', $data['content']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //Check Interview Invitation exists
    public function checkInterviewInvitationStatus($user_id, $status)
    {
        $this->db->query('SELECT * FROM interviewinvitation WHERE  user_id = :user_id AND invitation_status = :status');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':status', $status);

        $row = $this->db->single();

        //Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    //Get Interview Invitation
    public function getInterviewInvitation($user_id)
    {
        $this->db->query('SELECT * FROM interviewinvitation WHERE  user_id = :user_id');
        $this->db->bind(':user_id', $user_id);

        $row = $this->db->single();

        return $row;
    }

    //Get Interview Invitation
    public function getInterviewInvitationTime($interview_id)
    {
        $this->db->query('SELECT interview_date FROM interview WHERE  interview_id = :interview_id');
        $this->db->bind(':interview_id', $interview_id);

        $result = $this->db->single()->interview_date;

        //Split $result into date and time and return them
        $date = date('d-m-Y', strtotime($result));
        $time = date('H:i', strtotime($result));

        return array($date, $time, $result);
    }

    //Accept Interview Invitation
    public function acceptInterviewInvitation($interview_id)
    {
        $this->db->query('UPDATE interviewinvitation SET invitation_status = "Accepted" WHERE interview_id = :interview_id');
        $this->db->bind(':interview_id', $interview_id);

        $this->db->execute();
    }

    //Decline Interview Invitation
    public function declineInterviewInvitation($interview_id)
    {
        $this->db->query('UPDATE interviewinvitation SET invitation_status = "Declined" WHERE interview_id = :interview_id');
        $this->db->bind(':interview_id', $interview_id);

        $this->db->execute();
    }

    //Accept late Interview Invitation
    public function acceptLateInterviewInvitation($interview_id)
    {
        $this->db->query('UPDATE interviewinvitation SET invitation_status = "Late" WHERE interview_id = :interview_id');
        $this->db->bind(':interview_id', $interview_id);

        $this->db->execute();
    }
}
