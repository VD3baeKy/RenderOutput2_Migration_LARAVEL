<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;
  use Illuminate\Support\Facades\DB;

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
    // 「複雑なレビュー+ハウス+ユーザーDTO」検索
    // ResourceやDTO用配列で返す (SQL JOIN)
    // ページネーション対応

    // house_idでハウス価格昇順
    public static function byHouseIdOrderByHousePriceAsc($houseId, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                // 必要なhouseカラム追加
                'users.id as user_id',
                'users.name as user_name'
                // 必要なuserカラム追加
            )
            ->where('houses.id', $houseId)
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // house_idでレビュー更新日降順
    public static function byHouseIdOrderByReviewUpdatedAtDesc($houseId, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('houses.id', $houseId)
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // ハウス名or住所LIKEでハウス価格昇順
    public static function byHouseNameOrAddressLikeOrderByHousePriceAsc($keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where(function($q) use ($keyword) {
                $q->where('houses.name', 'like', "%$keyword%")
                  ->orWhere('houses.address', 'like', "%$keyword%");
            })
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // ハウス名or住所LIKEでレビュー更新日降順
    public static function byHouseNameOrAddressLikeOrderByReviewUpdatedAtDesc($keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where(function($q) use ($keyword) {
                $q->where('houses.name', 'like', "%$keyword%")
                  ->orWhere('houses.address', 'like', "%$keyword%");
            })
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // ハウス住所LIKEでハウス価格昇順
    public static function byHouseAddressLikeOrderByHousePriceAsc($keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('houses.address', 'like', "%$keyword%")
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // ハウス住所LIKEでレビュー更新日降順
    public static function byHouseAddressLikeOrderByReviewUpdatedAtDesc($keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('houses.address', 'like', "%$keyword%")
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // 電話番号、名前、住所から検索してハウス価格昇順
    public static function byPhoneNumberOrHouseNameOrAddressLikeOrderByHousePriceAsc($phoneStr, $keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'houses.phone_number as house_phone_number',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where(function($q) use ($phoneStr, $keyword) {
                $q->where('houses.phone_number', 'like', "%$phoneStr%")
                  ->orWhere('houses.name', 'like', "%$keyword%")
                  ->orWhere('houses.address', 'like', "%$keyword%");
            })
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // 電話番号、名前、住所から検索してレビュー更新日降順
    public static function byPhoneNumberOrHouseNameOrAddressLikeOrderByReviewUpdatedAtDesc($phoneStr, $keyword, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'houses.phone_number as house_phone_number',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where(function($q) use ($phoneStr, $keyword) {
                $q->where('houses.phone_number', 'like', "%$phoneStr%")
                  ->orWhere('houses.name', 'like', "%$keyword%")
                  ->orWhere('houses.address', 'like', "%$keyword%");
            })
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // ハウス価格〇円以下でハウス価格昇順
    public static function byHousePriceLessThanEqualOrderByHousePriceAsc($maxPrice, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('houses.price', '<=', $maxPrice)
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // ハウス価格〇円以下レビュー更新日降順
    public static function byHousePriceLessThanEqualOrderByReviewUpdatedAtDesc($maxPrice, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('houses.price', '<=', $maxPrice)
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // ユーザーIDで、ハウス価格昇順
    public static function byUserIdOrderByHousePriceAsc($userId, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('reviews.user_id', $userId)
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // ユーザーIDで、レビュー更新日降順
    public static function byUserIdOrderByReviewUpdatedAtDesc($userId, $perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->where('reviews.user_id', $userId)
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // 全件ハウス価格昇順
    public static function allOrderByHousePriceAsc($perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->orderBy('houses.price', 'asc');
        return $query->paginate($perPage);
    }

    // 全件レビュー更新日降順
    public static function allOrderByReviewUpdatedAtDesc($perPage = 10){
        $query = DB::table('reviews')
            ->join('houses', 'reviews.house_id', '=', 'houses.id')
            ->join('users',  'reviews.user_id',  '=', 'users.id')
            ->select(
                'reviews.*',
                'houses.id as house_id',
                'houses.name as house_name',
                'houses.price as house_price',
                'houses.address as house_address',
                'users.id as user_id',
                'users.name as user_name'
            )
            ->orderBy('reviews.updated_at', 'desc');
        return $query->paginate($perPage);
    }

    // ========================
    // 物理DELETEメソッド
    public static function deleteById($id){
        // Eloquent標準の destroy でも可
        return static::destroy($id);
    }
  }
