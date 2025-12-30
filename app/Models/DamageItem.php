<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageItem extends Model
{
    protected $fillable = [
        'damage_id',
        'name',
        'quantity',
        'unit',
        'description',
    ];

    public function damage()
    {
        return $this->belongsTo(Damage::class);
    }
}
