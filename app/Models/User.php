<?php

  namespace app\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable; // for Auth
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Factories\HasFactory;

  class User extends Authenticatable{
    use HasFactory, Notifiable;

    // テーブル名
    protected $table = 'users';

    // プライマリキー
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    // タイムスタンプ
    public $timestamps = true; // created_at, updated_at

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

    // 隠蔽属性（例えばパスワードがJSONレスポンスに出ないように）
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

    // 必要なら↓リレーション追加 (予約やレビューなど)
    // public function reservations()
    // {
    //     return $this->hasMany(Reservation::class);
    // }
  }
