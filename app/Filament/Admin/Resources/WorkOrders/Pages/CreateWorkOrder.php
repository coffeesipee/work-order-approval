<?php

namespace App\Filament\Admin\Resources\WorkOrders\Pages;

use App\Filament\Admin\Resources\WorkOrders\WorkOrderResource;
use App\Models\WorkOrder;
use App\Models\WorkOrderApproval;
use App\Models\WorkOrderAttachment;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateWorkOrder extends CreateRecord
{
    protected static string $resource = WorkOrderResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Input Pengajuan Work Order';
    }

    public function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $user = auth()->user();
        $unit = $user->unit;
        $region = $unit->region;
        $unitWoCount = WorkOrder::where('unit_id', $unit->id)->count();
        $ticketNumber = $unitWoCount + 1 . '/' . $unit->code . '/IV/' . now()->format('YYYY');

        $workOrderPayload = [
            'title' => $data['title'],
            'description' => $data['description'],
            'work_order_type' => $data['work_order_type'],
            'unit_id' => $unit->id,
            'region_id' => $region->id,
            'requester_id' => $user->id,
            'status' => $data['status'] ?? WorkOrder::STATUS_SUBMITTED,
            'ticket_number' => $ticketNumber,
            'damage_id' => $data['damage_id'],
        ];
        dd($workOrderPayload, $data);

        $workOrder = WorkOrder::create($workOrderPayload);
        $workOrder->items()->createMany($data['items']);

        foreach ($data['approvals'] as $index => $approval) {
            WorkOrderApproval::create([
                'work_order_id' => $workOrder->id,
                'status' => 'PENDING',
                'approver_id' => $approval['approver_id'],
            ]);
        }

        foreach ($data['attachments'] as $index => $attachment) {
            WorkOrderAttachment::create([
                'work_order_id' => $workOrder->id,
                'file_name' => $attachment['file_name'],
            ]);
        }

        return $workOrder;
    }
}
