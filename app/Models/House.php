<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Builder;

  class House extends Model{
    protected $table = 'houses';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'image_name',
        'description',
        'price',
        'capacity',
        'postal_code',
        'address',
        'phone_number',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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

    // ===== クエリスコープ =====

    public function scopeNameLike(Builder $query, $keyword){
        return $query->where('name', 'like', $keyword);
    }

    public function scopeNameOrAddressLikeOrderByCreatedAtDesc(Builder $query, $name, $address){
        return $query->where(function($q) use ($name, $address) {
                $q->where('name', 'like', $name)
                  ->orWhere('address', 'like', $address);
            })
            ->orderBy('created_at', 'desc');
    }

    public function scopeNameOrAddressLikeOrderByPriceAsc(Builder $query, $name, $address){
        return $query->where(function($q) use ($name, $address) {
                $q->where('name', 'like', $name)
                  ->orWhere('address', 'like', $address);
            })
            ->orderBy('price', 'asc');
    }

    public function scopeAddressLikeOrderByCreatedAtDesc(Builder $query, $area){
        return $query->where('address', 'like', $area)
                     ->orderBy('created_at', 'desc');
    }

    public function scopeAddressLikeOrderByPriceAsc(Builder $query, $area){
        return $query->where('address', 'like', $area)
                     ->orderBy('price', 'asc');
    }

    public function scopePriceLessThanEqualOrderByCreatedAtDesc(Builder $query, $price){
        return $query->where('price', '<=', $price)
                     ->orderBy('created_at', 'desc');
    }

    public function scopePriceLessThanEqualOrderByPriceAsc(Builder $query, $price){
        return $query->where('price', '<=', $price)
                     ->orderBy('price', 'asc');
    }

    public function scopeOrderByCreatedAtDesc(Builder $query){
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOrderByPriceAsc(Builder $query){
        return $query->orderBy('price', 'asc');
    }

    // == リレーション例（必要に応じて） ==
    // public function reviews() {
    //     return $this->hasMany(Review::class);
    // }
  }
