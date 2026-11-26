<?php

namespace App\Filament\Resources\ProductVariants\Schemas;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class ProductVariantForm
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
                // Section::make('color_info')
                //     ->schema([
                //         TextInput::make('color_name')
                //             ->label('Color Name')
                //             ->required(),
                //         TextInput::make('color_code')
                //             ->label('Color Code (Hex)')
                //             ->required()
                //             ->regex('/^#?([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/'),
                //     ])
                //     ->columns(2),

                Select::make('sort_by')
                    ->label('Sort By')
                    ->options(function (Get $get) {
                        $hasColorName = collect($get('color_attributes'))->contains(fn ($row) => filled($row['name']));
                        $customNames = collect($get('custom_attributes'))->pluck('name')
                            ->filter(fn ($item) => $item);
                        $names = $customNames
                            ->when($hasColorName, fn ($collection) => $collection->prepend('Color'))
                            ->toArray();

                        logger('these are the colors', $names);

                        return $names;
                    })
                    ->selectablePlaceholder(false)
                    ->default('')
                    ->saved(false)
                    ->live(),
                Section::make([
                    Flex::make([
                        Text::make('Variant'),
                        Text::make(''),
                        Text::make('Price'),
                        Text::make(''),

                    ]),
                    Flex::make([
                        Checkbox::make('is_dfest')
                            ->hiddenLabel(),

                        FileUpload::make('fsdkfjeio')
                            ->panelAspectRatio('1:1')
                            ->view('icons.image')
                            ->placeholder(' ')
                            ->hiddenLabel(),
                        // Text::make('dd')->color('neutral'),
                        //                 TextEntry::make('blue')->label(fn () => new HtmlString(
                        //                     // Injects standard Tailwind styling directly into the HTML string text
                        //                     '<span class="px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 animate-pulse">
                        //     System Online
                        //  </span>'
                        //                 ))->belowContent('black'),
                        TextInput::make('price')
                            ->hiddenLabel(),
                        TextInput::make('stock')->hiddenLabel(),
                    ])
                    // ->extraAttributes(['class' => 'items-center bg-blue'])
                    ,
                ]),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                TextInput::make('stock')
                    ->required()
                    ->numeric(),
            ]);
    }
}
