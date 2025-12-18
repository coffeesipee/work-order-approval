<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\PemeriksaanWorkOrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPemeriksaanWorkOrder extends ViewRecord
{
    protected static string $resource = PemeriksaanWorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
