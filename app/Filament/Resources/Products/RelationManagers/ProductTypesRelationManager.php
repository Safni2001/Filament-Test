<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Tables\Table;
use App\Models\ProductType;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DetachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;

class ProductTypesRelationManager extends RelationManager
{
    protected static string $relationship = 'productTypes';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pivot.my_bonus_field')
                    ->label('Bonus Field')
                    ->searchable(),
                TextColumn::make('pivot.created_at')
                    ->label('Assigned At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->form([
                        TextInput::make('name')
                            ->label('Product Type Name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ProductType::class, 'name'),
                        TextInput::make('api_unique_number')
                            ->label('API Unique Number')
                            ->numeric()
                            ->nullable(),
                        TextInput::make('my_bonus_field')
                            ->label('Bonus Field')
                            ->placeholder('Additional metadata about this type assignment')
                            ->maxLength(255),
                    ])
                    ->action(function ($data, $livewire) {
                        $productType = ProductType::create([
                            'name' => $data['name'],
                            'api_unique_number' => $data['api_unique_number'] ?? null,
                        ]);

                        $livewire->ownerRecord->productTypes()->attach($productType->id, [
                            'my_bonus_field' => $data['my_bonus_field'] ?? null,
                        ]);
                    }),
            ])
            ->recordActions([
                DeleteAction::make()
                    ->action(function ($record, $livewire) {
                        $livewire->ownerRecord->productTypes()->detach($record->id);
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->action(function ($records, $livewire) {
                            $livewire->ownerRecord->productTypes()->detach($records->pluck('id'));
                        }),
                ]),
            ]);
    }
}