<?php

namespace App\Filament\Admin\Resources\WorkOrders\Pages;

use App\Filament\Admin\Resources\WorkOrders\WorkOrderResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateWorkOrder extends CreateRecord
{
    protected static string $resource = WorkOrderResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Input Pengajuan Work Order';
    }
}
