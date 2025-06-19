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

    // \Illuminate\Contracts\Auth\Authenticatable で必要（実は getAuthPassword でOKだが Java互換で getPassword も用意）
    public function getPassword(){
        return $this->password;
    }

    // Springでの「ユーザー名」→ここではメールアドレス
    public function getUsername(){
        return $this->email;
    }

    // 権限（ロール名）
    public function getAuthorities(){
        // 単一ロールを前提
        return $this->role ? [$this->role->name] : [];
    }

    // アカウントが有効（enabledで管理）
    public function isEnabled(){
        return (bool)$this->enabled;
    }

    // アカウント期限切れ・ロック・資格期限切れの判定（デフォルトtrue、将来変えたければ拡張）
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
    // 予約やレビュー等のリレーションも追加OK
    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class);
    // }
  }
