<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\DB;

  class Loves extends Model{
    // テーブル名
    protected $table = 'loves';

    // 主キー
    protected $primaryKey = 'id';

    // プライマリキー自動増分
    public $incrementing = true;

    // キーの型
    protected $keyType = 'int';

    // タイムスタンプ自動管理 (created_at, updated_at)
    // 今回は created_at のみなので、$timestamps = false
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

    // =======================
    // クエリスコープ
    // =======================

    // ユーザーID & ハウスIDで取得 + 作成日降順（ページネーション対応）
    public function scopeUserIdAndHouseIdOrderByCreatedAtDesc(Builder $query, $userId, $houseId){
        return $query->where('user_id', $userId)
                     ->where('house_id', $houseId)
                     ->orderBy('created_at', 'desc');
    }

    // ユーザーIDで取得 + 作成日降順
    public function scopeUserIdOrderByCreatedAtDesc(Builder $query, $userId){
        return $query->where('user_id', $userId)
                     ->orderBy('created_at', 'desc');
    }

    // =======================
    // お気に入り＋ハウス情報をDTO的に返す（SQL JOIN）
    // =======================
    // ※DTOクラス自体はLaravelでは使わず直接配列/コレクション返しが一般的
    // ※ページネーションしたい場合は paginate($perPage) を使う

    public static function getFavoriteHouses($userId, $perPage = 10){
        // SQLベースJoin
        $query = DB::table('loves')
            ->join('houses', 'loves.house_id', '=', 'houses.id')
            ->select(
                'loves.id as love_id',
                'loves.house_id',
                'loves.user_id',
                'loves.created_at as love_created_at',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.image_name',
                'houses.description',
                'houses.price',
                'houses.capacity',
                'houses.postal_code',
                'houses.address',
                'houses.phone_number',
                'houses.created_at as house_created_at',
                'houses.updated_at'
            )
            ->where('loves.user_id', $userId)
            ->orderBy('loves.created_at', 'desc');

        // ページネーション返却
        return $query->paginate($perPage);
        // ページネーション不要なら get() で良い
    }
  }
