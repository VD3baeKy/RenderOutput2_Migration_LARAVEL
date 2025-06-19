<?php

  namespace App\Http\Services;
  
  use App\Models\Review;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Storage;
  
  class ReviewsService{
      // 最新レビューの取得
      public function refreshReviews()    {
          // キャッシュクリアの概念はEloquentにはあまりないのでそのままallでOK
          return Review::all();
      }
  
      // 新規レビュー作成
      public function create(array $data)    {
          DB::transaction(function() use ($data) {
              $review = new Review();
              
              if (!empty($data['image'])) {
                  $originalName = $data['image']->getClientOriginalName();
                  $hashedName = $this->generateNewFileName($originalName);
                  // 保存先は 'public/review_img'
                  $path = $data['image']->storeAs('public/review_img', $hashedName);
                  $review->image_name = $hashedName;
              }
              
              $review->rating = $data['rating'];
              $review->review_text = $data['review_text'];
              $review->user_id = $data['user_id'];
              $review->house_id = $data['house_id'];
              $review->save();
          });
      }
  
      // レビュー編集
      public function update($id, array $data)    {
          DB::transaction(function() use ($id, $data) {
              $review = Review::findOrFail($id);
  
              if (!empty($data['image'])) {
                  $originalName = $data['image']->getClientOriginalName();
                  $hashedName = $this->generateNewFileName($originalName);
                  $data['image']->storeAs('public/review_img', $hashedName);
                  $review->image_name = $hashedName;
              }
  
              $review->rating = $data['rating'];
              $review->review_text = $data['review_text'];
              $review->save();
          });
      }
  
      // UUID付きファイル名生成
      public function generateNewFileName($fileName)    {
          $parts = explode('.', $fileName);
          for ($i = 0; $i < count($parts) - 1; $i++) {
              $parts[$i] = (string) Str::uuid();
          }
          return implode('.', $parts);
      }
  }
