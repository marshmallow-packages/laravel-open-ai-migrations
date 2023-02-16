# Marshmallow - Laravel Open AI Migrations

[![marshmallow.](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")](https://marshmallow.dev)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/laravel-open-ai-migrations.svg)](https://packagist.org/packages/marshmallow/laravel-open-ai-migrations)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/laravel-open-ai-migrations.svg)](https://packagist.org/packages/marshmallow/laravel-open-ai-migrations)
[![License](https://img.shields.io/packagist/l/marshmallow/laravel-open-ai-migrations.svg)](https://gitlab.com/marshmallowdev)
[![Stars](https://img.shields.io/github/stars/marshmallow-packages/laravel-open-ai-migrations?color=yellow&style=plastic)](https://github.com/marshmallow-packages/laravel-open-ai-migrations)
[![Forks](https://img.shields.io/github/forks/marshmallow-packages/laravel-open-ai-migrations?color=brightgreen&style=plastic)](https://github.com/marshmallow-packages/laravel-open-ai-migrations)

# What It Do?!

## This command

```bash
artisan make:ai-migration "Add is_active and published_at to the posts table after intro"

INFO  Migration [database/migrations/2023_02_16_082621_change_the_slug_column_in_blogs_to_be_nullable_and_unique.php] created successfully.
INFO  Estimated costs of [$0.00302] for using [151] tokens.
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

### Install via Composer

```bash
composer require marshmallow/laravel-open-ai-migrations
```

### Publish the config file

```bash
php artisan vendor:publish --tag=laravel-open-ai-migrations
```

### Add your API Key

Add your Open AI API key to your `.env` file.

```env
OPEN_AI_API_KEY="sk-xxxxxxx"
```

### Update the config file

After you've published the config file, you need to add your Open AI API token. There is also some other magic you can do there, you should realy check it out.

# Usage

Run the AI Migration command with a description of what you want this migration to do.

```bash
artisan make:ai-migration "Change the slug column in blogs to be nullable and unique"
```

After this artisan command is ready, you will have a full migration file in your migrations folder with exactly that!

```php
public function up()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->string('slug')->nullable()->unique()->change();
    });
}
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
