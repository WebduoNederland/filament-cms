# Upgrading

## From v1 to v2

### Breaking changes

#### Laravel 13, Filament 5, and Livewire 4 are now required

This version of the package requires:

- PHP 8.3 or higher
- Laravel 13 or higher
- Filament 5
- Livewire 4

#### Livewire component aliases changed

If you published this package's config before, you need to update the Livewire component aliases in `config/filament-cms.php`.

Change:

```php
'livewire_component' => 'filament-cms::simple-text',
'blog_component' => 'filament-cms::blog-post',
```

To:

```php
'livewire_component' => 'filament-cms.simple-text',
'blog_component' => 'filament-cms.blog-post',
```

If you added custom builder blocks, update any custom `livewire_component` values there as well.

The old `filament-cms::...` aliases are no longer supported.

#### Clear your cached config

After updating your config, clear Laravel's caches:

```bash
php artisan optimize:clear
```

#### Rebuild Filament assets

After upgrading, rebuild the Filament assets:

```bash
php artisan filament:assets
```

#### Run your migrations

After the upgrade, run:

```bash
php artisan migrate
```

### Other changes

These changes were made inside the package and usually do not require action unless you extended package internals directly:

- The package now uses the newer Filament 5 schema APIs internally.
- The translatable fields dependency was upgraded to a newer major version.
- The image optimizer dependency was replaced with a newer compatible package.
