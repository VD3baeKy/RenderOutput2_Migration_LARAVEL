<?php

  namespace app\Models;

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

    // リレーション：ユーザー（OneToOneとほぼ同じ, belongsTo でOK）
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
