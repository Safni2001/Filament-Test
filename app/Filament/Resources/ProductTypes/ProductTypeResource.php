<?php

namespace App\Filament\Resources\ProductTypes;

use App\Filament\Resources\ProductTypes\Pages\ManageProductTypes;
use App\Models\ProductType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;
    protected static string|\UnitEnum|null $navigationGroup = 'Product Types';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'Product Type';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('api_unique_number')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Product Type')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('api_unique_number')
                    ->numeric()
                    ->sortable(),
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
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductTypes::route('/'),
        ];
    }
}
