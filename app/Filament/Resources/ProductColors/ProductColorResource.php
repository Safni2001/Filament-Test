<?php

namespace App\Filament\Resources\ProductColors;

use App\Filament\Resources\ProductColors\Pages\ManageProductColors;
use App\Models\ProductColor;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductColorResource extends Resource
{
    protected static ?string $model = ProductColor::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Product Colors';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                ColorPicker::make('hex_code')
                    ->nullable(),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->maxLength(65535)
                    ->nullable(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                ColorColumn::make('hex_code')
                    ->label('Color')
                    ->copyable()
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
            'index' => ManageProductColors::route('/'),
        ];
    }
}
