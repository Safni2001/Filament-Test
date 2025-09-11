<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Tables\Table;
use App\Models\ProductType;
use App\Models\ProductColor;
use Filament\Actions\Action;
use App\Jobs\UpdateProductJob;
use App\Models\ProductCategory;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;

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
                    ->color(fn($record) => $record->productColor->hex_code ?? 'gray'),

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
                Action::make('update_description')
                    ->label('Update Description')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->form([
                        Textarea::make('new_description')
                            ->label('New Description')
                            ->required()
                            ->rows(3)
                            ->placeholder('Enter the new description for this product...')
                    ])
                    ->action(function (array $data, $record): void {
                        UpdateProductJob::dispatch($record->id, $data['new_description']);

                        Notification::make()
                            ->title('Job Dispatched')
                            ->body('Product description update job has been queued successfully!')
                            ->success()
                            ->send();
                    })
                    ->modalHeading('Update Product Description')
                    ->modalDescription('This will queue a job to update the product description and send a notification.')
                    ->modalSubmitActionLabel('Queue Update Job'),
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
