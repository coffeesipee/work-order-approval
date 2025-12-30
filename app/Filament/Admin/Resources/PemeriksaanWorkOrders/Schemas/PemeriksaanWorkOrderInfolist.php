<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class PemeriksaanWorkOrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    Group::make()
                        ->schema([
                            TextEntry::make('ticket_number')
                                ->badge()
                                ->label('Kode'),
                            TextEntry::make("title")
                                ->label("Judul"),
                            TextEntry::make("unit.name")
                                ->badge()
                                ->label("Unit"),
                            TextEntry::make("region.name")
                                ->badge()
                                ->label("Region"),
                            TextEntry::make("reportedBy.name")
                                ->label("Dilaporkan Oleh"),
                            TextEntry::make("approvedBy.name")
                                ->label("Disetujui/Ditolak Oleh"),
                            TextEntry::make("approvedAt")
                                ->label("Disetujui/Ditolak Pada")
                                ->dateTime(),
                            TextEntry::make('status')->badge()->color(fn($state) => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            }),
                            TextEntry::make('created_at')
                                ->label('Dibuat Pada')
                                ->dateTime()
                        ])
                ])->columnSpanFull(),

                Section::make([
                    Group::make()
                        ->schema([
                            TextEntry::make("description")
                                ->html()
                                ->label("Deskripsi"),
                        ])
                ])->columnSpanFull(),

                Section::make([
                    Group::make()
                        ->schema([
                            RepeatableEntry::make('damageItems')
                                ->label('Item Kerusakan')
                                ->schema([
                                    TextEntry::make("name")
                                        ->label("Nama"),
                                    TextEntry::make("quantity")
                                        ->numeric()
                                        ->label("Jumlah"),
                                    TextEntry::make("unit")
                                        ->label("Satuan"),
                                    TextEntry::make("description")
                                        ->html()
                                        ->label("Deskripsi"),
                                ])
                        ])
                ])->columnSpanFull(),

                Section::make([
                    RepeatableEntry::make('damageProofs')
                        ->label('Bukti Kerusakan')
                        ->schema([
                            ImageEntry::make("image")->url(fn($state) => Storage::temporaryUrl($state, now()->addMinutes(5)), true)
                        ])
                ])->columnSpanFull(),
            ]);
    }
}
