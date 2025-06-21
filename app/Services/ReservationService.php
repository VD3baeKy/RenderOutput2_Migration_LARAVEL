<?php

  namespace App\Services;
  
  use App\Models\Reservation;
  use App\Models\House;
  use App\Models\User;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Carbon;
  
  class ReservationService{
      /**
       * @param array $paymentIntentObject
       * @return Reservation
       */
      public function create(array $paymentIntentObject){
          return DB::transaction(function () use ($paymentIntentObject) {
              $reservation = new Reservation();
  
              $houseId = $paymentIntentObject['houseId'];
              $userId  = $paymentIntentObject['userId'];
  
              // EloquentのfindOrFail or find
              $house = House::findOrFail($houseId);
              $user  = User::findOrFail($userId);
  
              $reservation->house_id         = $house->id;
              $reservation->user_id          = $user->id;
              $reservation->checkin_date     = Carbon::parse($paymentIntentObject['checkinDate']);
              $reservation->checkout_date    = Carbon::parse($paymentIntentObject['checkoutDate']);
              $reservation->number_of_people = $paymentIntentObject['numberOfPeople'];
              $reservation->amount           = $paymentIntentObject['amount'];
  
              $reservation->save();
              return $reservation;
          });
      }
  
      /**
       * 宿泊人数が定員以下かどうかチェック
       */
      public function isWithinCapacity($numberOfPeople, $capacity){
          return $numberOfPeople <= $capacity;
      }
  
      /**
       * 宿泊料金を計算
       * @param string|Carbon $checkinDate
       * @param string|Carbon $checkoutDate
       * @param int $price
       * @return int
       */
      public function calculateAmount($checkinDate, $checkoutDate, $price){
          // Carbonインスタンス化
          $checkin  = $checkinDate instanceof Carbon ? $checkinDate : Carbon::parse($checkinDate);
          $checkout = $checkoutDate instanceof Carbon ? $checkoutDate : Carbon::parse($checkoutDate);
  
          $numberOfNights = $checkin->diffInDays($checkout);
          return $price * $numberOfNights;
      }
  }
