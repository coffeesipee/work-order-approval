<?php

namespace App\Filament\Admin\Resources\Regions\Pages;

use App\Filament\Admin\Resources\Regions\RegionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRegions extends ManageRecords
{
    protected static string $resource = RegionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Buat Region Baru'),
        ];
    }
}
