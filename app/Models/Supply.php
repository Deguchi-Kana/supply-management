<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'stock',
        'is_consumable',
        'expiration_date',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_supply');
    }

    public function images()
    {
        return $this->hasMany(SupplyImage::class);
    }

    public function bollows()
    {
        return $this->hasMany(BollowLog::class, 'supply_id', 'id');
    }
}
