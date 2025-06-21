<?php

  namespace App\Http\Services;
  
  use App\Models\User;
  use App\Models\Role;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\DB;
  
  class UserService{
      // ユーザー新規作成
      public function create(array $data){
          return DB::transaction(function() use ($data) {
              $role = Role::where('name', 'ROLE_GENERAL')->first();
  
              $user = new User();
              $user->name = $data['name'];
              $user->furigana = $data['furigana'] ?? null;
              $user->postal_code = $data['postal_code'] ?? null;
              $user->address = $data['address'] ?? null;
              $user->phone_number = $data['phone_number'] ?? null;
              $user->email = $data['email'];
              // パスワード暗号化
              $user->password = Hash::make($data['password']);
              $user->role_id = $role ? $role->id : null;
              $user->enabled = false;   // enabledの有無はDB設計次第
              $user->save();
              return $user;
          });
      }
  
      // ユーザー情報更新
      public function update(array $data){
          return DB::transaction(function() use ($data) {
              $user = User::findOrFail($data['id']);
              $user->name = $data['name'];
              $user->furigana = $data['furigana'] ?? null;
              $user->postal_code = $data['postal_code'] ?? null;
              $user->address = $data['address'] ?? null;
              $user->phone_number = $data['phone_number'] ?? null;
              $user->email = $data['email'];
              $user->save();
              return $user;
          });
      }
  
      // メールアドレスが登録済みかどうか
      public function isEmailRegistered(string $email): bool {
          return User::where('email', $email)->exists();
      }
  
      // パスワードと確認用が一致するか
      public function isSamePassword($password, $passwordConfirmation): bool {
          return $password === $passwordConfirmation;
      }
  
      // ユーザーを有効化
      public function enableUser(User $user){
          $user->enabled = true;
          $user->save();
      }
  
      // メールアドレスが変更されたかどうか
      public function isEmailChanged(array $data): bool {
          $currentUser = User::findOrFail($data['id']);
          return $data['email'] !== $currentUser->email;
      }
  
      // ユーザーが存在するか
      public function doesUserExist(int $userId): bool {
          return User::where('id', $userId)->exists();
      }
  
      // ユーザー名をIDから取得（例1: なければnull返し）
      public function getUserNameById(?int $userId): ?string {
          $user = User::find($userId);
          return $user ? $user->name : null;
      }
  
      // ユーザー名をIDから取得（例2: 無理やりget()で例外が欲しい場合）
      public function getUserNameById2(int $userId): ?string {
          return User::findOrFail($userId)->name;
      }
  }

