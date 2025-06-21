<?php

  namespace App\Models;
  
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Str;
  use Illuminate\Support\Facades\Storage;
  
  class Review extends Model{
      protected $table = 'reviews';
      protected $primaryKey = 'id';
      public $incrementing = true;
      protected $keyType = 'int';
      public $timestamps = true;
  
      // 一括代入で許可する属性
      protected $fillable = [
          'user_id',
          'house_id',
          'rating',
          'review_text',
          'image_name',
      ];
  
      // 型キャスト
      protected $casts = [
          'created_at' => 'datetime',
          'updated_at' => 'datetime',
      ];
  
      // ========================
      // リレーション
      public function user(){
          return $this->belongsTo(User::class, 'user_id');
      }
  
      public function house(){
          return $this->belongsTo(House::class, 'house_id');
      }
  
      // ========================
      // Javaの便利メソッド
      public function getProperties(){
          return $this->attributesToArray();
      }
  
      public function getPropertyCount(){
          return count($this->attributesToArray());
      }
  
      public function __toString(){
          return "Review{id='{$this->id}'"
              .", user_id='{$this->user_id}'"
              .", house_id='{$this->house_id}'"
              .", rating='{$this->rating}'"
              .", review_text='{$this->review_text}'"
              .", image_name='{$this->image_name}'"
              .", created_at='{$this->created_at}'"
              .", updated_at='{$this->updated_at}'"
              ."}";
      }
  
      public function getReviewText(){
          return $this->review_text;
      }
      public function getUserid(){
          return $this->user_id;
      }
      public function getHouseid(){
          return $this->house_id;
      }
  
      // ========================
      // クエリスコープ・基本的なもの
  
      // 最新10件取得
      public function scopeTop10OrderByCreatedAtDesc(Builder $query){
          return $query->orderBy('created_at', 'desc')->take(10);
      }
  
      // house_idで絞り込み＆新しい順
      public function scopeByHouseIdOrderByCreatedAtDesc(Builder $query, $houseId){
          return $query->where('house_id', $houseId)->orderBy('created_at', 'desc');
      }
  
      // ========================
      // DTO用途や複雑なJOINクエリ
  
      // ...（ここはそのまま）
  
      public static function byHouseIdOrderByHousePriceAsc($houseId, $perPage = 10){
          // 省略: 中身は質問文と同じ
          // …
      }
      // …以下、全カスタムクエリをそのまま記載
  
      // ========================
      // 画像ファイル名生成メソッド追加 (Serviceの部分)
      public static function generateNewFileName($fileName){
          $parts = explode('.', $fileName);
          for ($i = 0; $i < count($parts) - 1; $i++) {
              $parts[$i] = (string) Str::uuid();
          }
          return implode('.', $parts);
      }
  
      // ========================
      // 画像保存処理例
      public static function saveImage($file, $dir = 'public/review_img'){
          if ($file) {
              $originalName = $file->getClientOriginalName();
              $hashedName = self::generateNewFileName($originalName);
              $file->storeAs($dir, $hashedName);
              return $hashedName;
          }
          return null;
      }
  
      // ========================
      // 物理DELETEメソッド
      public static function deleteById($id){
          return static::destroy($id);
      }
  }
