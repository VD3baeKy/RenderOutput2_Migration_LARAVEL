<?php

  namespace app\Services;
  use app\Models\User;

  class UserService{
    public function updateProfile(User $user, $data){
        $user->name         = $data['name'];
        $user->furigana     = $data['furigana'] ?? '';
        $user->postal_code  = $data['postal_code'] ?? '';
        $user->address      = $data['address'] ?? '';
        $user->phone_number = $data['phone_number'] ?? '';
        $user->email        = $data['email'];
        $user->save();
    }
  }
