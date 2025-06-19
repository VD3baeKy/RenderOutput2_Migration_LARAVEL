<?php

  namespace app\models;

  use Illuminate\Database\Eloquent\Model;

  class Loves extends Model{
    // テーブル名（省略時は loves なので不要だが、念のため）
    protected $table = 'loves';

    // 主キー
    protected $primaryKey = 'id';

    // プライマリキー自動増分
    public $incrementing = true;

    // キーの型
    protected $keyType = 'int';

    // タイムスタンプ自動管理 (created_at, updated_at)
    // 今回は created_at のみなので、$timestamps = false とし、casts で個別管理
    public $timestamps = false;

    // 一括代入許可
    protected $fillable = [
        'house_id',
        'user_id',
        'created_at',
    ];

    // 日付キャスト
    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Houseリレーション
    public function house(){
        return $this->belongsTo(House::class, 'house_id');
    }

    // Userリレーション
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
  }
