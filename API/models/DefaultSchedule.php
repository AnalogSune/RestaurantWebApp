<?php 
class DefaultSchedule{
    public $opentime;
    public $closetime;
    public $reservationDuration;
    public $availableTables;

    public function GetOpenTime() {
        return intval(date('H', strtotime($this->opentime)));
    }

    public function GetCloseTime() {
        return intval(date('H', strtotime($this->closetime)));
    }
}
?>