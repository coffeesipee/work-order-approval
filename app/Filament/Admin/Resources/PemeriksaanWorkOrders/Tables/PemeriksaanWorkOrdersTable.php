<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PemeriksaanWorkOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_number')
                    ->label('Kode Kerusakan')
                    ->badge()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('unit.name')
                    ->badge()
                    ->label('Unit')
                    ->searchable(),
                TextColumn::make('region.name')
                    ->badge()
                    ->label('Region')
                    ->searchable(),
                TextColumn::make('reportedBy.name')
                    ->label('Dilaporkan Oleh')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            // ->modifyQueryUsing(fn(Builder $query) => $query->where('status', 'pending'))
            ->emptyStateHeading('Tidak ada data')
            ->emptyStateDescription('Work order yang harus di periksa belum ditemukan')
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()->label('Lihat'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
