<?php

namespace App\Filament\Admin\Resources\WorkOrders;

use App\Filament\Admin\Resources\WorkOrders\Pages\CreateWorkOrder;
use App\Filament\Admin\Resources\WorkOrders\Pages\EditWorkOrder;
use App\Filament\Admin\Resources\WorkOrders\Pages\ListWorkOrders;
use App\Filament\Admin\Resources\WorkOrders\Pages\ViewWorkOrder;
use App\Filament\Admin\Resources\WorkOrders\Schemas\WorkOrderForm;
use App\Filament\Admin\Resources\WorkOrders\Schemas\WorkOrderInfolist;
use App\Filament\Admin\Resources\WorkOrders\Tables\WorkOrdersTable;
use App\Models\WorkOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkOrderResource extends Resource
{
    protected static ?string $model = WorkOrder::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Pengajuan';
    protected static UnitEnum|string|null $navigationGroup = 'Work Order';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $modelLabel = 'Pengajuan';
    protected static ?string $pluralLabel = 'Pengajuan';

    public static function form(Schema $schema): Schema
    {
        return WorkOrderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkOrderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkOrdersTable::configure($table);
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
            'index' => ListWorkOrders::route('/'),
            'create' => CreateWorkOrder::route('/create'),
            'view' => ViewWorkOrder::route('/{record}'),
            'edit' => EditWorkOrder::route('/{record}/edit'),
        ];
    }
}
