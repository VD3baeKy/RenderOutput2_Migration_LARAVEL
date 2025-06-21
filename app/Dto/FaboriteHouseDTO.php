<?php

  namespace App\DTO;

  use App\Models\Loves;
  use App\Models\House;

  class FaboriteHouseDTO{
    public $loves;
    public $house;

    public function __construct(Loves $loves, House $house){
        $this->loves = $loves;
        $this->house = $house;
    }

    public function getLoves(){
        return $this->loves;
    }

    public function getHouse(){
        return $this->house;
    }

    public function toArray(){
        return [
            'loves' => $this->loves,
            'house' => $this->house,
        ];
    }

    public function __toString(){
        // PHPの標準としてechoやprint時の内容
        return "FaboriteHouseDTO{" .
            "loves=" . $this->loves .
            ", house=" . $this->house .
        "}";
    }
  }
