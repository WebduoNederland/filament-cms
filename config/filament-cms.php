<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CMS Path
    |--------------------------------------------------------------------------
    |
    | This is the path that will be used to enter the Filament CMS
    |
    */
    'path' => '/cms',

    /*
    |--------------------------------------------------------------------------
    | Components
    |--------------------------------------------------------------------------
    |
    | Define components which can be used in the pages content builder
    |
    */
    'components' => [
        'simple_text' => [
            'filament_block' => \WebduoNederland\FilamentCms\Filament\Blocks\SimpleTextBlock::class,
            'livewire_component' => 'filament-cms::simple-text',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | This value determines the layout all pages will use when rendering
    |
    */
    'layout' => 'filament-cms::layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Time formatting
    |--------------------------------------------------------------------------
    |
    | This value determines the time formatting used across the panel
    |
    */
    'time_format' => 'd-m-Y H:i',

    /*
    |--------------------------------------------------------------------------
    | Route middlewares
    |--------------------------------------------------------------------------
    |
    | A list of middlewares which will be hit on each page request
    |
    */
    'route_middleware' => [
        \WebduoNederland\FilamentCms\Http\Middleware\RedirectMiddleware::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Multi language
    |--------------------------------------------------------------------------
    |
    | Enable multi language route support
    |
    */
    'multi_language_enabled' => false,

    /*
    |--------------------------------------------------------------------------
    | Default language
    |--------------------------------------------------------------------------
    |
    | Define the default language for your website
    |
    */
    'multi_language_default' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Available multi languages
    |--------------------------------------------------------------------------
    |
    | Define the languages used on your website
    |
    */
    'multi_languages' => [
        'en' => 'English',
        'nl' => 'Dutch',
    ],
];
