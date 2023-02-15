# Marshmallow - Laravel Open AI Migrations

[![marshmallow.](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")](https://marshmallow.dev)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/laravel-open-ai-migrations.svg)](https://packagist.org/packages/marshmallow/laravel-open-ai-migrations)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/laravel-open-ai-migrations.svg)](https://packagist.org/packages/marshmallow/laravel-open-ai-migrations)
[![License](https://img.shields.io/packagist/l/marshmallow/laravel-open-ai-migrations.svg)](https://gitlab.com/marshmallowdev)
[![Stars](https://img.shields.io/github/stars/marshmallow-packages/laravel-open-ai-migrations?color=yellow&style=plastic)](https://github.com/marshmallow-packages/laravel-open-ai-migrations)
[![Forks](https://img.shields.io/github/forks/marshmallow-packages/laravel-open-ai-migrations?color=brightgreen&style=plastic)](https://github.com/marshmallow-packages/laravel-open-ai-migrations)

# What It Do

## This command

```bash
artisan ai:migration "Add is_active and published_at to the posts table after intro"
```

## Will turn into this!!

```php
Schema::table('posts', function (Blueprint $table) {
    $table->after('intro', function (Blueprint $table) {
        $table->boolean('is_active')->default(true);
        $table->dateTime('published_at')->nullable();
    });
});
```

## Installation

You can install the package via composer:

```bash
composer require marshmallow/laravel-open-ai-migrations
```

And publish the service provider (and config):

```bash
php artisan vendor:publish --tag=laravel-open-ai-migrations
```

Usage:

```bash
artisan ai:migration {description}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Stef van Esch](https://github.com/stefvanesch)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
