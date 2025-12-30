<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damage extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'unit_id',
        'region_id',
        'approved_by',
        'approved_at',
        'reported_by',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function damageItems()
    {
        return $this->hasMany(DamageItem::class);
    }

    public function damageProofs()
    {
        return $this->hasMany(DamageProof::class);
    }
}
