<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderApproval extends Model
{
    protected $fillable = [
        'work_order_id',
        'approver_id',
        'sequence',
        'status',
        'approved_at',
        'rejected_at',
        'rejected_reason',
    ];

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
