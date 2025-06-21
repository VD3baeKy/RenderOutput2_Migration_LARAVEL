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
    // UserRepositoryの各メソッド
    public static function findByEmail($email){
        return static::where('email', $email)->first();
    }

    public function scopeNameLikeOrFuriganaLike(Builder $query, $nameKeyword, $furiganaKeyword){
        return $query->where(function($q) use ($nameKeyword, $furiganaKeyword) {
            $q->where('name', 'like', $nameKeyword)
              ->orWhere('furigana', 'like', $furiganaKeyword);
        });
    }

    public static function existsById($id){
        return static::where('id', $id)->exists();
    }

    public static function findById($id){
        return static::find($id);
    }

    // ========================
    // UserDetailsImpl的メソッド

    public function getPassword(){
        return $this->password;
    }

    public function getUsername(){
        return $this->email;
    }

    public function getAuthorities(){
        return $this->role ? [$this->role->name] : [];
    }

    public function isEnabled(){
        return (bool)$this->enabled;
    }

    public function isAccountNonExpired(){
        return true;
    }
    public function isAccountNonLocked(){
        return true;
    }
    public function isCredentialsNonExpired(){
        return true;
    }

    public function getUserId(){
        return $this->id;
    }

    // ========================
    // UserDetailsImplDummy的メソッド
    /**
     * ダミーユーザー（認証失敗時など）の静的生成
     */
    public static function dummy(){
        $user = new static();
        $user->id = -1;
        $user->email = '';
        $user->furigana = '';
        $user->name = '';
        $user->password = null;
        $user->address = '';
        $user->created_at = null;
        $user->enabled = true;
        $user->phone_number = null;
        $user->postal_code = null;
        $user->updated_at = null;
        $user->role_id = null;
        // $user->setRelation('role', null); // 明示的にnullにしたい場合

        return $user;
    }

    public function isDummy(){
        return $this->id === -1;
    }

    // ========================
    // 必要なら予約やレビュー等のリレーション追加もここにOK
    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class);
    // }
  }
