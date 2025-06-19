<?php

  namespace App\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Builder;

  class User extends Authenticatable{
    use HasFactory, Notifiable;

    // テーブル名
    protected $table = 'users';

    // プライマリキー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプ
    public $timestamps = true;

    // 一括代入許可
    protected $fillable = [
        'name',
        'furigana',
        'postal_code',
        'address',
        'phone_number',
        'email',
        'password',
        'role_id',
        'enabled',
    ];

    // 隠蔽属性
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 型変換
    protected $casts = [
        'enabled'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // リレーション：Role
    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    // ========================
    // UserRepositoryの各メソッドをスコープ等で再現

    // Java: User findByEmail(String email);
    public static function findByEmail($email){
        return static::where('email', $email)->first();
    }

    // Java: Page<User> findByNameLikeOrFuriganaLike(String nameKeyword, String furiganaKeyword, Pageable pageable);
    public function scopeNameLikeOrFuriganaLike(Builder $query, $nameKeyword, $furiganaKeyword){
        return $query->where(function($q) use ($nameKeyword, $furiganaKeyword) {
            $q->where('name', 'like', $nameKeyword)
              ->orWhere('furigana', 'like', $furiganaKeyword);
        });
    }

    // Java: boolean existsById(Integer id);
    public static function existsById($id){
        return static::where('id', $id)->exists();
    }

    // Java: Optional<User> findById(Integer id);
    // → Laravel: find()またはfirst()
    public static function findById($id){
        return static::find($id); // 見つからない場合nullを返す（Optional相当）
    }

    // 必要なら予約やレビュー等のリレーションも追加OK
    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class);
    // }
  }
