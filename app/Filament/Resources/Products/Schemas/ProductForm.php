<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        $isMoreThanOne = function (Repeater $component) {
            $rows = $component->getState() ?? [];

            return count($rows) > 1;
        };

        return $schema
            ->components([
                TextInput::make('name'),
                Textarea::make('description'),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                // * Image Gallery
                Repeater::make('images')
                    ->label('Image Gallery')
                    ->addActionLabel('+ Add Image')
                    ->relationship('images')
                    ->orderColumn('sort_order') // / column to store sort
                    ->schema([
                        FileUpload::make('url')
                            ->hiddenLabel()
                            // ->placeholder(fn () => view('filament.components.upload-image'))
                            ->disk('local')
                            ->image()
                            ->requiredWith('alt'),
                        Textarea::make('alt')
                            ->hiddenLabel()
                            ->placeholder('Describe your image')
                            ->requiredWith('url'),
                    ])
                    ->collapsible($isMoreThanOne)
                    ->reorderable($isMoreThanOne)
                    ->deletable($isMoreThanOne)
                    ->grid(4),
                // * Attributes
                Section::make([
                    Select::make('attribute')
                        ->options([
                            'color_attributes' => 'Color',
                            'custom_attributes' => 'Custom',
                        ])
                        // ->selectablePlaceholder(false)
                        ->default('color_attributes')
                        ->saved(false)
                        ->hiddenLabel(),
                    // TextInput::make()
                    // * Color
                    Repeater::make('color_attributes')
                        ->hiddenLabel()
                        ->schema([
                            TextInput::make('name')
                                ->placeholder('e.g., Midnight Blue')
                                ->label('Color Name')
                                ->distinct()
                                ->requiredWith('code'),
                            ColorPicker::make('code')
                                ->label('Hex Code')
                                ->hexColor()
                                ->placeholder('Pick a color')
                                ->requiredWith('name'),
                        ])
                        ->columns(2)
                        ->reorderable($isMoreThanOne)
                        ->deletable($isMoreThanOne)
                        ->default([['name' => 'Crimson', 'code' => '#dfd'], ['name' => 'Maroon', 'code' => '#efa']])
                        ->addActionLabel('+ Add Row')
                        // ->visible(fn (Get $get) => $get('attribute') == 'color_attributes')
                        ->visibleJs(<<<'JS'
                    $get('attribute') === 'color_attributes'
                    JS),
                    // * Custom
                    Repeater::make('custom_attributes')
                        ->hiddenLabel()
                        ->schema([
                            TextInput::make('name')
                                ->placeholder('e.g., Size, Material, etc.')
                                ->label('Custom Label')
                                ->requiredWith('values'),
                            TagsInput::make('values')
                                ->label('Values')
                                ->placeholder('Type a value and press Enter')
                                // ->extraInputAttributes([])
                                ->requiredWith('name'),
                        ])
                        ->reorderable($isMoreThanOne)
                        ->deletable($isMoreThanOne)
                        ->addActionLabel('+ Add Row')
                        // ->visible(fn (Get $get) => $get('attribute') == 'custom_attributes')
                        ->visibleJs(<<<'JS'
                    $get('attribute') === 'custom_attributes'
                    JS),

                ])
                    ->label('Variants')
                    ->live(),
            ]);
    }
}
