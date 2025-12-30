<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Unit extends Model
{
    protected static function booted()
    {
        static::creating(function (Unit $unit) {
            if (!empty($unit->code))
                return;

            $code = Str::slug($unit->name);
            $unit->code = Str::upper($code);
        });
    }

    protected $fillable = [
        'name',
        'code',
        'description',
        'region_id'
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
