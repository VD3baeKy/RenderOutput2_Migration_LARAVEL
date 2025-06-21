<?php

  namespace App\Services;
  
  use App\Models\House;
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Str;
  use Illuminate\Http\UploadedFile;
  use Illuminate\Support\Facades\DB;
  
  class HouseService{
      /**
       * 登録処理
       * @param  \Illuminate\Http\Request|array $data
       * @return House
       */
      public function create($form){
          return DB::transaction(function () use ($form) {
              $house = new House();
  
              // LaravelではUploadedFile型
              /** @var UploadedFile|null $imageFile */
              $imageFile = $form['image_file'] ?? null;
              if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                  $hashedImageName = $this->generateNewFileName($imageFile->getClientOriginalName());
                  // 例: storage/app/public/storage/
                  $path = $imageFile->storeAs('public/storage', $hashedImageName);
                  $house->image_name = $hashedImageName;
              }
  
              $house->name = $form['name'];
              $house->description = $form['description'];
              $house->price = $form['price'];
              $house->capacity = $form['capacity'];
              $house->postal_code = $form['postal_code'];
              $house->address = $form['address'];
              $house->phone_number = $form['phone_number'];
  
              $house->save();
  
              return $house;
          });
      }
  
      /**
       * 更新処理
       * @param  \Illuminate\Http\Request|array $form
       * @return House
       */
      public function update($form){
          return DB::transaction(function () use ($form) {
              $house = House::findOrFail($form['id']);
  
              /** @var UploadedFile|null $imageFile */
              $imageFile = $form['image_file'] ?? null;
              if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
                  $hashedImageName = $this->generateNewFileName($imageFile->getClientOriginalName());
                  $path = $imageFile->storeAs('public/storage', $hashedImageName);
                  $house->image_name = $hashedImageName;
              }
  
              $house->name = $form['name'];
              $house->description = $form['description'];
              $house->price = $form['price'];
              $house->capacity = $form['capacity'];
              $house->postal_code = $form['postal_code'];
              $house->address = $form['address'];
              $house->phone_number = $form['phone_number'];
  
              $house->save();
  
              return $house;
          });
      }
  
      /**
       * UUIDでファイル名を生成
       */
      public function generateNewFileName($fileName){
          $fileNames = explode('.', $fileName);
          $ext = array_pop($fileNames);
          foreach($fileNames as &$part) {
              $part = (string) Str::uuid();
          }
          $hashedFileName = implode('.', $fileNames) . '.' . $ext;
          return $hashedFileName;
      }
  
      // 画像ファイルのコピーはstoreAsで十分なので省略（Laravel流では storage/app/public へ置く）
  }
