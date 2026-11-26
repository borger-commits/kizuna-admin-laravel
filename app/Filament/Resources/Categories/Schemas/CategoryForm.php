<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                // Textarea::make('description')
                //     ->required()
                //     ->default('')
                //     ->columnSpanFull(),
                Section::make([
                    FileUpload::make('imageUrl')
                        ->hiddenLabel()
                        ->image(),
                    Textarea::make('imageAlt')
                        ->label('Description')
                        ->requiredWith('imageUrl'),
                ])->label('Banner'),

            ]);
    }
}
