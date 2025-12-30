<?php

namespace App\Filament\Admin\Resources\PemeriksaanWorkOrders;

use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages\CreatePemeriksaanWorkOrder;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages\EditPemeriksaanWorkOrder;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages\ListPemeriksaanWorkOrders;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Pages\ViewPemeriksaanWorkOrder;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Schemas\PemeriksaanWorkOrderForm;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Schemas\PemeriksaanWorkOrderInfolist;
use App\Filament\Admin\Resources\PemeriksaanWorkOrders\Tables\PemeriksaanWorkOrdersTable;
use App\Models\Damage;
use App\Models\PemeriksaanWorkOrder;
use App\Models\WorkOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PemeriksaanWorkOrderResource extends Resource
{
    protected static ?string $model = Damage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Lapor Kerusakan';
    protected static UnitEnum|string|null $navigationGroup = 'Work Order';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Lapor Kerusakan';
    protected static ?string $pluralLabel = 'Lapor Kerusakan';


    public static function form(Schema $schema): Schema
    {
        return PemeriksaanWorkOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PemeriksaanWorkOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PemeriksaanWorkOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPemeriksaanWorkOrders::route('/'),
            'create' => CreatePemeriksaanWorkOrder::route('/create'),
            'view' => ViewPemeriksaanWorkOrder::route('/{record}'),
            'edit' => EditPemeriksaanWorkOrder::route('/{record}/edit'),
        ];
    }
}
