<?php

class Feedback{
    
    private $TrainerID;
    private $MemberID;
    private $feedback;

    public function getTrainerID() {
        return $this->TrainerID;
    }

    public function getMemberID() {
        return $this->MemberID;
    }

    public function getFeedback() {
        return $this->feedback;
    }

    public function setTrainerID($TrainerID) {
        $this->TrainerID = $TrainerID;
    }

    public function setMemberID($MemberID) {
        $this->MemberID = $MemberID;
    }

    public function setFeedback($feedback) {
        $this->feedback = $feedback;
    }


 
}

