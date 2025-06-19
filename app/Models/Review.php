<?php

  namespace app\Models;

  use Illuminate\Database\Eloquent\Model;

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

    // 属性の型キャスト
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // -----------------------
    // リレーション（必要に応じて追加）
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function house(){
        return $this->belongsTo(House::class, 'house_id');
    }

    // -----------------------
    // JavaのgetProperties()やtoString()はPHPでは不要だが、サンプルとして下記

    // 全プロパティを配列で返す（toArrayで十分ですがサンプルで独自に定義）
    public function getProperties(){
        return $this->attributesToArray();
    }

    // プロパティ数を返す
    public function getPropertyCount(){
        return count($this->attributesToArray());
    }

    // JavaのtoString的なメソッド
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

    // Javaと同じプロパティ名でゲッター
    public function getReviewText(){
        return $this->review_text;
    }
    public function getUserid(){
        return $this->user_id;
    }
    public function getHouseid(){
        return $this->house_id;
    }
  }
