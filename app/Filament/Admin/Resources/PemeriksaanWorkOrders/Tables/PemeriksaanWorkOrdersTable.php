<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Builder;
use Filament\Tables\Table;

class PemeriksaanWorkOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'pending'))
            ->emptyStateHeading('Tidak ada data')
            ->emptyStateDescription('Work order yang harus di periksa belum ditemukan')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
