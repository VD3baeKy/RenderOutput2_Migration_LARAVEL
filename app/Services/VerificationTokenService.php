<?php
  
  namespace App\Services;
  
  use App\Models\VerificationToken;
  use App\Models\User;
  use Illuminate\Support\Facades\DB;
  
  class VerificationTokenService{
      // トークン作成
      public function create(User $user, string $token){
          // トランザクション化（厳密な必要がなければ省略可）
          return DB::transaction(function() use ($user, $token) {
              return VerificationToken::create([
                  'user_id' => $user->id,
                  'token'   => $token,
              ]);
          });
      }
  
      // トークンで検索
      public function getVerificationToken(string $token): ?VerificationToken {
          return VerificationToken::where('token', $token)->first();
      }
  }
