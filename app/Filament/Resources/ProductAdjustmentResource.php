<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAdjustmentResource\Pages;
use App\Filament\Resources\ProductAdjustmentResource\RelationManagers;
use App\Models\ProductAdjustment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductAdjustmentResource extends Resource
{
    protected static ?string $model = ProductAdjustment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Product';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('adjustment_date')
                    ->required(),
                Select::make('product_id')
                    ->relationship(name: 'product', titleAttribute: 'name')
                    ->required(),
                Select::make('warehouse_id')
                    ->relationship(name: 'warehouse', titleAttribute: 'name')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                Select::make('type')
                    ->options([
                        'addition' => 'Addition',
                        'subtraction' => 'Subtraction',
                    ])
                    ->required(),
                TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('adjustment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('warehouse.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type'),
                TextColumn::make('reason')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProductAdjustments::route('/'),
            'create' => Pages\CreateProductAdjustment::route('/create'),
            'edit' => Pages\EditProductAdjustment::route('/{record}/edit'),
        ];
    }
}
