<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DamageProof extends Model
{
    protected $fillable = [
        'damage_id',
        'image',
    ];

    public function damage()
    {
        return $this->belongsTo(Damage::class);
    }

    public function getImageUrlAttribute()
    {
        return Storage::temporaryUrl($this->image, now()->addMinutes(5));
    }
}
