<?php

class Enrollment{
     
    private $SessionStartTime;
    private $SessionEndTime;
    private $StartDate;
    private $EndDate;  
    private $Payment; 
    private $packageNo;
    public function getSessionStartTime() {
        return $this->SessionStartTime;
    }

    public function getSessionEndTime() {
        return $this->SessionEndTime;
    }

    public function getStartDate() {
        return $this->StartDate;
    }

    public function getEndDate() {
        return $this->EndDate;
    }

    public function getPayment() {
        return $this->Payment;
    }

    public function getPackageNo() {
        return $this->packageNo;
    }

    public function setSessionStartTime($SessionStartTime) {
        $this->SessionStartTime = $SessionStartTime;
    }

    public function setSessionEndTime($SessionEndTime) {
        $this->SessionEndTime = $SessionEndTime;
    }

    public function setStartDate($StartDate) {
        $this->StartDate = $StartDate;
    }

    public function setEndDate($EndDate) {
        $this->EndDate = $EndDate;
    }

    public function setPayment($Payment) {
        $this->Payment = $Payment;
    }

    public function setPackageNo($packageNo) {
        $this->packageNo = $packageNo;
    }


}

