<?php

namespace App\Filament\Resources\ProductImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('variant_id')
                    ->relationship('variant', 'id')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                FileUpload::make('url')
                    ->disk('s3')
                    ->directory('products')
                    ->image(),
                TextInput::make('alt_text')
                    ->required()
                    ->default('Product Image'),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
