<?php

  namespace App\Dto;

  class ReviewEditForm2{
    public $contentChange;
    public $ratingChange;

    public function __construct($contentChange, $ratingChange){
        $this->contentChange = $contentChange;
        $this->ratingChange = $ratingChange;
    }
  }
