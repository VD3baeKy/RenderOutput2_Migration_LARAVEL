<?php

  namespace app\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;

  class Reservation extends Model{
    // テーブル名
    protected $table = 'reservations';

    // 主キー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプ自動管理
    public $timestamps = true;

    // 一括代入を許可する属性
    protected $fillable = [
        'house_id',
        'user_id',
        'checkin_date',
        'checkout_date',
        'number_of_people',
        'amount',
        // 'created_at', 'updated_at' は自動管理なので不要
    ];

    // 属性の型キャスト
    protected $casts = [
        'checkin_date'  => 'date',
        'checkout_date' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    // ------------ リレーション ------------

    // Houseリレーション
    public function house(){
        return $this->belongsTo(House::class, 'house_id');
    }

    // Userリレーション
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    // ------------ クエリスコープ ------------

    /**
     * 指定ユーザの予約一覧を作成日降順（ページネーション用）
     * 例: Reservation::ofUserOrderByCreatedAtDesc($userId)->paginate(10);
     */
    public function scopeOfUserOrderByCreatedAtDesc(Builder $query, $userId){
        // user_idで絞り、created_at降順
        return $query->where('user_id', $userId)
                     ->orderBy('created_at', 'desc');
    }
  }
