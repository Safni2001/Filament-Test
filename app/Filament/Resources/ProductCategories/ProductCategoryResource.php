<?php

namespace App\Filament\Resources\ProductCategories;

use App\Filament\Resources\ProductCategories\Pages\EditProductCategory;
use App\Filament\Resources\ProductCategories\Pages\ManageProductCategories;
use App\Filament\Resources\ProductCategories\RelationManagers\ProductTypesRelationManager;
use App\Models\ProductCategory;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-folder';

    protected static string|\UnitEnum|null $navigationGroup = 'Product Categories';

    protected static ?int $navigationSort = 2;
    protected static ?string $recordTitleAttribute = 'Product Category';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('external_url'),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->nullable(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Product Category')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('external_url')
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

    public static function getRelations(): array
    {
        return [
            ProductTypesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProductCategories::route('/'),
            'edit' => EditProductCategory::route('/{record}/edit'),
        ];
    }
}
