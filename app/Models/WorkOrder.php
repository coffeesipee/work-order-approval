<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected static function booted(): void
    {
        static::created(function (WorkOrder $workOrder) {
            // WorkOrderHistory::create([
            //     'work_order_id' => $workOrder->id,
            //     'user_id' => $workOrder->requester_id,
            //     'before_status' => $workOrder->status,
            //     'after_status' => $workOrder->status,
            //     'action' => 'CREATE',
            // ]);
        });
    }

    const STATUS_DRAFT = 'DRAFT';
    const STATUS_SUBMITTED = 'SUBMITTED';
    const STATUS_IN_PROGRESS = 'IN_PROGRESS';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_COMPLETED = 'COMPLETED';

    const TYPE_PEMERIKSAAN = 'PEMERIKSAAN';
    const TYPE_PERBAIKAN = 'PERBAIKAN';
    const TYPE_PARTS = 'PARTS';
    const TYPE_PEMINDAHAN = 'PEMINDAHAN';

    protected $fillable = [
        'title',
        'description',
        'ticket_number',
        'requester_id',
        'status',
        'completed_at',
        'rejected_at',
        'reject_reason',
        'damage_id',
    ];

    public function damage()
    {
        return $this->belongsTo(Damage::class);
    }

    public function attachments()
    {
        return $this->hasMany(WorkOrderAttachment::class);
    }

    public function approvals()
    {
        return $this->hasMany(WorkOrderApproval::class);
    }

    public function history()
    {
        return $this->hasMany(WorkOrderHistory::class);
    }

    public function items()
    {
        return $this->hasMany(WorkOrderItem::class);
    }
}
