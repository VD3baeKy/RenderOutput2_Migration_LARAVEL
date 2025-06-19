<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;

  class Role extends Model{
    // テーブル名（Laravelの規約通りrolesなので省略も可）
    protected $table = 'roles';

    // プライマリーキー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプを使わない
    public $timestamps = false;

    // 一括代入を許可する属性
    protected $fillable = [
        'name',
    ];

    // ======================
    // リレーション例（必要に応じて）
    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id');
    // }

    // ======================
    // 「名前で検索」機能の追加
    // ======================

    // スコープバージョン
    public function scopeName(Builder $query, $name){
        return $query->where('name', $name);
    }

    // 静的メソッドバージョン
    public static function findByName($name){
        return static::where('name', $name)->first();
    }
  }
