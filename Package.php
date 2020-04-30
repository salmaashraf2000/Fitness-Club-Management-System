<?php

class Package{
    private $PackageNumber;
    private $PackageInfo;
    private $JacuzziNo;
    private $SpaNo;
    private $SteamNo;
    private $SaunaNo;
    private $NumberOfMonths;
    private $Price;
    private $Discount;
    public function getPackageNumber() {
        return $this->PackageNumber;
    }

    public function getPackageInfo() {
        return $this->PackageInfo;
    }

    public function getJacuzziNo() {
        return $this->JacuzziNo;
    }

    public function getSpaNo() {
        return $this->SpaNo;
    }

    public function getSteamNo() {
        return $this->SteamNo;
    }

    public function getSaunaNo() {
        return $this->SaunaNo;
    }

    public function getNumberOfMonths() {
        return $this->NumberOfMonths;
    }

    public function getPrice() {
        return $this->Price;
    }

    public function getDiscount() {
        return $this->Discount;
    }

    public function setPackageNumber($PackageNumber) {
        $this->PackageNumber = $PackageNumber;
    }

    public function setPackageInfo($PackageInfo) {
        $this->PackageInfo = $PackageInfo;
    }

    public function setJacuzziNo($JacuzziNo) {
        $this->JacuzziNo = $JacuzziNo;
    }

    public function setSpaNo($SpaNo) {
        $this->SpaNo = $SpaNo;
    }

    public function setSteamNo($SteamNo) {
        $this->SteamNo = $SteamNo;
    }

    public function setSaunaNo($SaunaNo) {
        $this->SaunaNo = $SaunaNo;
    }

    public function setNumberOfMonths($NumberOfMonths) {
        $this->NumberOfMonths = $NumberOfMonths;
    }

    public function setPrice($Price) {
        $this->Price = $Price;
    }

    public function setDiscount($Discount) {
        $this->Discount = $Discount;
    }


}





