<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    const TYPE_SUPERADMIN = 'SUPERADMIN';
    const TYPE_VERIFICATOR = 'VERIFICATOR';
    const TYPE_REQUESTER = 'REQUESTER';
    const TYPE_APPROVER = 'APPROVER';

    protected $fillable = [
        'name',
        'type',
    ];
}
