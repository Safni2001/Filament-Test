<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('product_category_id')
                    ->relationship('productCategory', 'name')
                    ->required(),
                Select::make('product_color_id')
                    ->relationship('productColor', 'name')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}