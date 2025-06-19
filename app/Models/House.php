<?php

  namespace app\Models;

  use Illuminate\Database\Eloquent\Model;

  class House extends Model{
    // テーブル名 (デフォルト=hous**es**なので省略可)
    protected $table = 'houses';

    // プライマリキー名
    protected $primaryKey = 'id';

    // IDの自動増分
    public $incrementing = true;

    // IDの型
    protected $keyType = 'int';

    // タイムスタンプ自動管理 (created_at, updated_at)
    public $timestamps = true;

    // ホワイトリスト方式で代入を許可する属性
    protected $fillable = [
        'name',
        'image_name',
        'description',
        'price',
        'capacity',
        'postal_code',
        'address',
        'phone_number',
        // 'created_at', 'updated_at' は通常自動管理なので不要
    ];

    // 日時型にキャストする属性 (Eloquentが自動でCarbon型へ)
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // toString的な表示
    public function __toString(){
        return "House{id='{$this->id}'"
            .", name='{$this->name}'"
            .", description='{$this->description}'"
            .", price='{$this->price}'"
            .", capacity='{$this->capacity}'"
            .", postal_code='{$this->postal_code}'"
            .", address='{$this->address}'"
            .", phone_number='{$this->phone_number}'"
            .", image_name='{$this->image_name}'"
            .", created_at='{$this->created_at}'"
            .", updated_at='{$this->updated_at}'"
            ."}";
    }

    // リレーション（例: reviews, reservations など）
    // public function reviews() {
    //     return $this->hasMany(Review::class);
    // }
  }
