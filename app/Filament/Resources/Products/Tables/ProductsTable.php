<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('productCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                
                TextColumn::make('productColor.name')
                    ->label('Color')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => $record->productColor->hex_code ?? 'gray'),
                
                TextColumn::make('productTypes.name')
                    ->label('Product Types')
                    ->badge()
                    ->separator(', ')
                    ->searchable()
                    ->toggleable()
                    ->color('info'),
                
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('product_category_id')
                    ->label('Category')
                    ->options(ProductCategory::all()->pluck('name', 'id'))
                    ->preload(),
                
                SelectFilter::make('product_color_id')
                    ->label('Color')
                    ->options(ProductColor::all()->pluck('name', 'id'))
                    ->preload(),
                
                SelectFilter::make('product_type_id')
                    ->label('Product Type')
                    ->options(ProductType::all()->pluck('name', 'id'))
                    ->preload()
                    ->relationship('productTypes', 'name'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name')
            ->poll('30s');
    }
}
