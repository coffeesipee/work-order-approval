<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\PemeriksaanWorkOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPemeriksaanWorkOrders extends ListRecords
{
    protected static string $resource = PemeriksaanWorkOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Buat Laporan Kerusakan'),
        ];
    }
}
