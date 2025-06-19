<?php

  namespace app\Dto;

  class ReservationRegisterForm{
    public $houseId;
    public $userId;
    public $checkinDate;
    public $checkoutDate;
    public $numberOfPeople;
    public $amount;

    public function __construct($houseId, $userId, $checkinDate, $checkoutDate, $numberOfPeople, $amount){
        $this->houseId = $houseId;
        $this->userId = $userId;
        $this->checkinDate = $checkinDate;
        $this->checkoutDate = $checkoutDate;
        $this->numberOfPeople = $numberOfPeople;
        $this->amount = $amount;
    }
  }
