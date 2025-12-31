<?php

namespace App\Filament\Admin\Resources\WorkOrders\Schemas;

use App\Models\Damage;
use App\Models\Role;
use App\Models\User;
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
                            Select::make('damage_id')
                                ->label('Kerusakan')
                                ->required(false)
                                ->searchable()
                                ->preload()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $damage = Damage::with(['damageItems'])->find($state);
                                    $set('title', $damage->title);
                                    $set('description', $damage->description);

                                    $items = [];
                                    $attachments = [];
                                    foreach ($damage->damageItems as $item) {
                                        $items[] = [
                                            'item_name' => $item->name,
                                            'item_description' => $item->item_description,
                                            'item_note' => '',
                                            'item_quantity' => $item->quantity,
                                            'item_unit' => $item->unit,
                                        ];
                                    }

                                    foreach ($damage->damageProofs as $proof) {
                                        $attachments[] = [
                                            'file_name' => [$proof->image],
                                        ];
                                    }
                                    $set('items', $items);
                                    $set('attachments', $attachments);
                                })
                                ->reactive()
                                ->live()
                                ->options(
                                    Damage::where('status', 'approved')
                                        ->where('unit_id', auth()->user()->unit_id)
                                        ->pluck('ticket_number', 'id')
                                ),
                            TextInput::make('title')
                                ->required()
                                ->reactive()
                                ->label('Judul')
                                ->columnSpanFull()
                                ->maxLength(100),
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->required()
                                ->reactive()
                                ->columnSpanFull()
                                ->maxLength(255),
                            Select::make('work_order_type')
                                ->label('Tipe Pekerjaan')
                                ->required()
                                ->multiple()
                                ->searchable()
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
                                            'pcs' => 'PCS',
                                            'kg' => 'KG',
                                            'l' => 'L',
                                            'm' => 'M',
                                            'm2' => 'M2',
                                            'm3' => 'M3',
                                            'mt' => 'MT',
                                            't' => 'T',
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
                                        ->options(function () {
                                            $role = Role::where('type', 'APPROVER')->pluck('id')->toArray();
                                            $users = User::whereHas('role', function ($query) use ($role) {
                                                $query->whereIn('role_id', $role);
                                            })->pluck('name', 'id')->toArray();
                                            return $users;
                                        })
                                        ->required(),
                                ])
                        ])
                ])
                    ->columnSpanFull()
                    ->skippable(),
            ]);
    }
}
