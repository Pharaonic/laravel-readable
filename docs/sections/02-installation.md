## Installation

Install the package with Composer. Laravel discovers the service provider and the `Readable` alias automatically.

### Requirements

- PHP 8.0, 8.1 or 8.2
- Laravel 9.33 or newer within 9.x
- `pharaonic/php-readable` 8.0.3+ on PHP 8.0, 8.1.2+ on PHP 8.1 or 8.2.2+ on PHP 8.2 (installed automatically)
- `ext-intl`, only to spell numbers in a language other than English

### Composer Installation

```bash title="Terminal" no-line-numbers
composer require pharaonic/laravel-readable
```

There is no configuration to publish and no migration to run.

:::success Installation Complete
You're all set! Try `@readableNumber(10203040)` in any Blade view.
:::
