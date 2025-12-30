<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PemeriksaanWorkOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Select::make('unit_id')
                    ->label('Unit')
                    ->relationship('unit', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('region_id')
                    ->label('Region')
                    ->relationship('region', 'name')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),

                Repeater::make('damageItems')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('unit')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->minItems(1)
                    ->columnSpan('full')
                    ->label('Item Kerusakan'),

                FileUpload::make('proofs')
                    ->multiple()
                    ->image()
                    ->visibility('public')
                    ->directory('damage-proofs')
                    ->imageEditor()
                    ->columnSpan('full')
                    ->label('Bukti Kerusakan'),
            ]);
    }
}
