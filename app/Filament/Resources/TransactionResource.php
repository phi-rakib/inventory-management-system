<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-bangladeshi';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Purchase';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required(),

                DateTimePicker::make('transact_at')
                    ->label('Date')
                    ->required(),

                Repeater::make('productTransaction')
                    ->relationship()
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required(),
                        TextInput::make('quantity')
                            ->required()
                            ->numeric(),
                        TextInput::make('unit_price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                        $product = Product::find($data['product_id']);

                        $product->quantity = $product->quantity + $data['quantity'];

                        $product->save();

                        return $data;
                    })
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    })
                    ->columnSpanFull(),

                TextInput::make('total')
                    ->numeric()
                    ->readOnly()
                    ->prefix('$')
                    ->afterStateHydrated(function (Get $get, Set $set) {
                        self::updateTotals($get, $set);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),
                TextColumn::make('supplier.name')
                    ->numeric()
                    ->sortable(),
                ColumnGroup::make('Product', [
                    TextColumn::make('productTransaction.product.name')
                        ->label('name')
                        ->listWithLineBreaks(),
                    TextColumn::make('productTransaction.quantity')
                        ->label('quantity')
                        ->listWithLineBreaks(),
                    TextColumn::make('productTransaction.product.unitType.name')
                        ->label('Unit')
                        ->listWithLineBreaks(),
                ])->alignCenter(),
                TextColumn::make('total')
                    ->label('Total Amount')
                    ->summarize(Sum::make()->label('Total Purchase Amount')),
                TextColumn::make('transact_at')
                    ->label('Purchase Date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])->defaultSort('transact_at', 'desc')
            ->filters([
                Filter::make('transact_at')
                    ->form([
                        DatePicker::make('purchase_from'),
                        DatePicker::make('purchase_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['purchase_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transact_at', '>=', $date),
                            )
                            ->when(
                                $data['purchase_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('transact_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('supplier')
                    ->relationship('supplier', 'name')
                    ->multiple()
                    ->searchable(),
                SelectFilter::make('product')
                    ->relationship('productTransaction.product', 'name')
                    ->multiple(),
            ], layout: FiltersLayout::Modal)
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $selectedProducts = collect($get('productTransaction'))->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) {
            return $subtotal + ($product['unit_price'] * $product['quantity']);
        }, 0);

        $set('total', number_format($subtotal, 2, '.', ''));
    }
}
