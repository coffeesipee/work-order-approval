<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\PemeriksaanWorkOrderResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

use App\Models\Damage;
use Filament\Forms\Components\RichEditor;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ViewPemeriksaanWorkOrder extends ViewRecord
{
    protected static string $resource = PemeriksaanWorkOrderResource::class;
    protected static ?string $title = 'Laporan Kerusakan';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Download Berita Acara')
                ->form(function (Damage $record) {
                    return [
                        RichEditor::make('content')
                            ->label('Document Content')
                            ->default(app(\App\Services\DamageService::class)->generateBeritaAcaraContent($record))
                            ->required(),
                    ];
                })
                ->action(function (array $data, Damage $record) {
                    $key = Str::random(40);
                    Cache::put($key, $data['content'], now()->addMinutes(10));

                    return redirect()->route('documents.berita-acara', [
                        'damage' => $record->id,
                        'content_key' => $key,
                    ])->with('success', 'Berita Acara berhasil dibuat');
                }),

            Action::make('Approve')
                ->action(function (Damage $record) {
                    $record->approved_by = auth()->user()->id;
                    $record->approved_at = now();
                    $record->status = 'approved';
                    $record->save();
                })
                ->visible(function (Damage $record) {
                    return $record->status === 'pending';
                }),

            Action::make('Reject')
                ->action(function (Damage $record) {
                    $record->approved_by = auth()->user()->id;
                    $record->approved_at = now();
                    $record->status = 'rejected';
                    $record->save();
                })
                ->visible(function (Damage $record) {
                    return $record->status === 'pending';
                }),
        ];
    }
}
