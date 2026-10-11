## Installation

Install the package with Composer. Laravel discovers the service provider and the `Readable` alias automatically.

### Requirements

- PHP 8.1, 8.2 or 8.3
- Laravel 10.0 or newer within 10.x
- `pharaonic/php-readable` 8.1.2+ on PHP 8.1, 8.2.2+ on PHP 8.2 or 8.3.2+ on PHP 8.3 (installed automatically)
- `ext-intl`, only to spell numbers in a language other than English

### Composer Installation

```bash title="Terminal" no-line-numbers
composer require pharaonic/laravel-readable
```

There is no configuration to publish and no migration to run.

:::success Installation Complete
You're all set! Try `@readableNumber(10203040)` in any Blade view.
:::
