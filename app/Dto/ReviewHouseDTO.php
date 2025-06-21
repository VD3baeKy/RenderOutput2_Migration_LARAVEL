<?php

  namespace App\DTO;

  use App\Models\Review;
  use App\Models\House;
  use App\Models\User;

  class ReviewHouseDTO{
    private $review;
    private $house;
    private $user;

    public function __construct(Review $review, House $house, User $user){
        $this->review = $review;
        $this->house = $house;
        $this->user = $user;
    }

    public function review(){
        return $this->review;
    }

    public function house(){
        return $this->house;
    }

    public function user(){
        return $this->user;
    }

    public function toArray(){
        return [
            'review' => $this->review,
            'house'  => $this->house,
            'user'   => $this->user,
        ];
    }

    public function __toString(){
        return "ReviewHouseDTO{" .
            "review=" . $this->review .
            ", house=" . $this->house .
            ", user=" . $this->user .
        "}";
    }
  }
