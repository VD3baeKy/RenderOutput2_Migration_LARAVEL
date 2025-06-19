<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class VerificationToken extends Model{
    // テーブル名
    protected $table = 'verification_tokens';

    // 主キー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプ自動管理 (created_at, updated_at)
    public $timestamps = true;

    // 一括代入許可プロパティ
    protected $fillable = [
        'user_id',
        'token',
    ];

    // 型キャスト
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // リレーション：ユーザー
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // ================================
    // トークンで検索（findByToken相当）
    // ================================
    public static function findByToken($token){
        return static::where('token', $token)->first();
    }

    // スコープ形式も使いたい場合
    public function scopeToken($query, $token){
        return $query->where('token', $token);
    }
  }
