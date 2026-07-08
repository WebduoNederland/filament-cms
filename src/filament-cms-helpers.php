<?php

if (! function_exists('filamentCmsMultiLangEnabled')) {
    function filamentCmsMultiLangEnabled(): bool
    {
        /** @var bool $enabled */
        $enabled = config('filament-cms.multi_language_enabled', false);

        return $enabled;
    }
}

if (! function_exists('getFilamentCmsFieldName')) {
    function getFilamentCmsFieldName(string $name): string
    {
        if (config('filament-cms.multi_language_enabled', false)) {
            return $name;
        }

        /** @var string $defaultLanguage */
        $defaultLanguage = config('filament-cms.multi_language_default', 'en');

        return $name.'.'.$defaultLanguage;
    }
}

if (! function_exists('getFilamentCmsLang')) {
    function getFilamentCmsLang(): string
    {
        $segments = request()->segments();

        $segmentCount = count($segments);

        /** @var string $default */
        $default = config('filament-cms.multi_language_default', 'en');

        /** @var array $multiLanguages */
        $multiLanguages = config('filament-cms.multi_languages', []);

        if (! config('filament-cms.multi_language_enabled', false) || $segmentCount === 0) {
            return $default;
        }

        if (array_key_exists($segments[0], $multiLanguages)) {
            return $segments[0];
        }

        return $default;
    }
}
