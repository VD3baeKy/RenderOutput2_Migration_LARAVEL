<?php

  namespace App\Services;

  use App\Models\User;

class CustomUserDetailsService{
    public function loadUserByUsername($email){
        $user = User::with('role')->where('email', $email)->first();

        if ($user) {
            // 任意の処理やデータ整形
            $roleName = $user->getRoleName();
            // Laravelではこのuserインスタンスをそのまま使うのが自然
            return $user;
        } else {
            // 見つからない場合はnullや例外・ダミー返却（お好みで）
            return null; // or throw new \Exception("User not found");
        }
    }
  }
