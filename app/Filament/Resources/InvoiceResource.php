<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\InvoiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Product;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\TextInput::make('invoice_number')
                                    ->default(Str::uuid())
                                    ->required(),
                                Forms\Components\DatePicker::make('invoice_date')
                                    ->default(now())
                                    ->required(),
                            ])->columns([
                                'sm'=> 2,
                            ]),
                        Forms\Components\Card::make()
                            ->schema([
                                Forms\Components\Placeholder::make('Products'),
                                Forms\Components\Repeater::make('invoiceItems')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Product')
                                            ->options(Product::query()->pluck('name', 'id'))
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(function($state, callable $set) {
                                                $product = Product::find($state);
                                                if ($product) {
                                                    $set('price', number_format($product->price/100, 2));
                                                    $set('product_price', $product->price);
                                                }
                                            })
                                            ->columnSpan([
                                                'md' => 5
                                            ]),
                                        Forms\Components\TextInput::make('product_amount')
                                            ->numeric()
                                            ->default(1)
                                            ->required()
                                            ->columnSpan([
                                                'md' => 2
                                            ]),
                                        Forms\Components\TextInput::make('price')
                                            ->disabled()
                                            ->numeric()
                                            ->default(1)
                                            ->dehydrated(false)
                                            ->columnSpan([
                                                'md' => 3
                                            ]),
                                        Forms\Components\Hidden::make('product_price')
                                            ->disabled()
                                    ])
                                    ->defaultItems(1)
                                    ->columns([
                                        'md' => 10
                                    ])
                                    ->columnSpan('full')
                            ]),
                    ])->columnSpan('full')
            ]);
    }

    public static function table(Table $table): Table  {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
