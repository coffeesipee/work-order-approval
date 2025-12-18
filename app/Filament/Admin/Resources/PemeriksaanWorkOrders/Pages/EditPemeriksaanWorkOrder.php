<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\PemeriksaanWorkOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPemeriksaanWorkOrder extends EditRecord
{
    protected static string $resource = PemeriksaanWorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
