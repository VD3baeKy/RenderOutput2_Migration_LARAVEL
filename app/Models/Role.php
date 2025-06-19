<?php

  namespace app\Models;

  use Illuminate\Database\Eloquent\Model;

  class Role extends Model{
    // テーブル名（Laravelの規約通りrolesなので省略もできる）
    protected $table = 'roles';

    // プライマリーキー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプ created_at/updated_at を使わない場合
    public $timestamps = false;

    // 一括代入を許可する属性
    protected $fillable = [
        'name',
    ];

    // 必要ならユーザーとのリレーションも追加（例）
    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id');
    // }
  }
