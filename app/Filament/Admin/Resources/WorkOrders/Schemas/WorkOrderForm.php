<?php

namespace App\Filament\Admin\Resources\WorkOrders\Schemas;

use App\Models\WorkOrder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class WorkOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Informasi Umum')
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            TextInput::make('title')
                                ->required()
                                ->label('Judul')
                                ->columnSpanFull()
                                ->maxLength(100),
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->required()
                                ->columnSpanFull()
                                ->maxLength(255),
                            Select::make('work_order_type')
                                ->label('Tipe Pekerjaan')
                                ->required()
                                ->options([
                                    WorkOrder::TYPE_PEMERIKSAAN => 'Pemeriksaan',
                                    WorkOrder::TYPE_PERBAIKAN => 'Perbaikan',
                                    WorkOrder::TYPE_PARTS => 'Parts Only',
                                    WorkOrder::TYPE_PEMINDAHAN => 'Pemindahan',
                                ])
                        ]),

                    Step::make('List Order')
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Repeater::make('items')
                                ->label('Item')
                                ->addActionLabel('Tambah Item')
                                ->schema([
                                    TextInput::make('item_name')
                                        ->required()
                                        ->label('Nama Item')
                                        ->maxLength(100),
                                    Textarea::make('item_description')
                                        ->label('Deskripsi Item')
                                        ->maxLength(255)->nullable(),
                                    Textarea::make('item_note')
                                        ->label('Catatan Item')
                                        ->maxLength(255)->nullable(),
                                    TextInput::make('item_quantity')
                                        ->required()
                                        ->numeric()
                                        ->label('Jumlah Item'),
                                    Select::make('item_unit')
                                        ->label('Satuan Item')
                                        ->options([
                                            'PCS' => 'PCS',
                                            'KG' => 'KG',
                                            'L' => 'L',
                                            'M' => 'M',
                                            'M2' => 'M2',
                                            'M3' => 'M3',
                                            'MT' => 'MT',
                                            'T' => 'T',
                                        ]),
                                ])->columnSpanFull(),
                        ]),

                    Step::make('Lampiran')
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Repeater::make('attachments')
                                ->label('Lampiran')
                                ->schema([
                                    Textarea::make('notes')
                                        ->label('Catatan')
                                        ->maxLength(255),
                                    FileUpload::make('file_name')
                                        ->disk('local')
                                        ->label('File')
                                        ->directory('work-order-attachments')
                                        ->imageEditor()
                                        ->image()
                                ])->addActionLabel('Tambah Lampiran'),
                        ]),

                    Step::make('Skema Persetujuan')
                        ->completedIcon(Heroicon::HandThumbUp)
                        ->schema([
                            Repeater::make('approvals')
                                ->label('Skema Persetujuan')
                                ->addActionLabel('Tambah Persetujuan')
                                ->schema([
                                    Select::make('approver_id')
                                        ->label('PIC')
                                        ->required(),
                                ])
                        ])
                ])
                    ->columnSpanFull()
                    ->skippable(),
            ]);
    }
}
