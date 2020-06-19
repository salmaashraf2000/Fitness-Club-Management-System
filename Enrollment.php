<?php


require_once 'Payment.php';
class Enrollment{
     
    private $SessionStartTime;
    private $SessionEndTime;
    private $StartDate;
    private $EndDate;  
    private $payment;
    private $TrainerID;


    public function __construct($payment)
    {
        $this->payment=new Payment();
        $this->payment->setCash($payment->getCash());
        $this->payment->setElectronic($payment->getElectronic());
        
    }
        
    public function getSessionStartTime()
    {
        return $this->SessionStartTime;
    }

    public function getSessionEndTime() 
    {
        return $this->SessionEndTime;
    }

    public function getStartDate()
    {
        return $this->StartDate;
    }

    public function getEndDate() 
    {
        return $this->EndDate;
    }

    public function getPayment()
    {
        
        if($this->payment->getCash()==true)
        {
            return 'cash';
        } else 
        {
            return 'electronic';
        }
    }

    public function setSessionStartTime($SessionStartTime) 
    {
        $this->SessionStartTime = $SessionStartTime;
    }

    public function setSessionEndTime($SessionEndTime)
    {
        $this->SessionEndTime = $SessionEndTime;
    }

    public function setStartDate($StartDate)
    {
        $this->StartDate = $StartDate;
    }

    public function setEndDate($EndDate) 
    {
        $this->EndDate = $EndDate;
    }



    public function getTrainerID() {
        return $this->TrainerID;
    }

    public function setTrainerID($TrainerID)
    {
        $this->TrainerID = $TrainerID;
    }

    public function CalculateEndDate($date,$Months)
    {
        return date('Y-m-d', strtotime('+'.$Months.'months'));
    }

}

