<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderItem extends Model
{
    protected $fillable = [
        'work_order_id',
        'item_name',
        'item_description',
        'item_note',
        'item_quantity',
        'item_unit',
    ];
}
