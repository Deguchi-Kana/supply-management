<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BollowLog extends Model
{
    protected $table = 'bollow_logs';

    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supply_id', 'id');
    }
}
