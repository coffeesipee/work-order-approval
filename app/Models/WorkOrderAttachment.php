<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrderAttachment extends Model
{
    protected $fillable = [
        'work_order_id',
        'file_name',
        'file_size',
        'attachment_type',
        'notes',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
}
