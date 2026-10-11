## Installation

Install the package with Composer. Laravel discovers the service provider and the `Readable` alias automatically.

### Requirements

- PHP 8.0
- Laravel 6.20 or newer within 6.x
- `pharaonic/php-readable` 8.0.1+ within 8.0.x (installed automatically)
- `ext-intl`, only to spell numbers in a language other than English

### Composer Installation

```bash title="Terminal" no-line-numbers
composer require pharaonic/laravel-readable
```

There is no configuration to publish and no migration to run.

:::success Installation Complete
You're all set! Try `@readableNumber(10203040)` in any Blade view.
:::
