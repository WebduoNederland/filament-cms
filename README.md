# Filament CMS

Highly advanced CMS for your Laravel website built with FilamentPHP!

## Requirements

- Laravel 11 or higher
- PHP 8.3 or higher

## Installation

You can install the package via composer:
```bash
composer require webduonederland/filament-cms
```

After installing the package, make sure you setup the Filament assets:
```bash
php artisan filament:assets
```

Publish the config file:
```bash
php artisan vendor:publish --provider="WebduoNederland\FilamentCms\FilamentCmsServiceProvider" --tag="config"
```

Run the migrations:
```bash
php artisan migrate
```

Add the following command to your composer.json post-autoload-dump:
```json
"post-autoload-dump": [
    // ...
    "@php artisan filament:upgrade"
],
```

## Creating an admin

```bash
php artisan filament-cms:create-user
```

## Accessing the CMS

The CMS can be accessed through the ``/cms`` path.

## Create your first component

```bash
php artisan filament-cms:create-component
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
