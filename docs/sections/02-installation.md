## Installation

Install the package with Composer. Laravel discovers the service provider and the `Readable` alias automatically.

### Requirements

- PHP 8.2, 8.3, 8.4 or 8.5
- Laravel 12.0 or newer within 12.x
- `pharaonic/php-readable` 8.2.2+ on PHP 8.2, 8.3.2+ on PHP 8.3, 8.4.2+ on PHP 8.4 or 8.5.2+ on PHP 8.5 (installed automatically)
- `ext-intl`, only to spell numbers in a language other than English

### Composer Installation

```bash title="Terminal" no-line-numbers
composer require pharaonic/laravel-readable
```

There is no configuration to publish and no migration to run.

:::success Installation Complete
You're all set! Try `@readableNumber(10203040)` in any Blade view.
:::
