<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyImage extends Model
{
    use HasFactory;

    protected $fillable = ['file_path', 'supply_id'];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
