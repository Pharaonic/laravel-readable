# Maintaining This Package

This file records package-specific maintainer facts that are safe to keep in the public repository.

## Purpose

Readable numbers, dates, durations, and file sizes for Laravel, exposed as static `Readable` methods, global helpers, and Blade directives.

## Supported Laravel lines

One branch per Laravel major, from `6.x` to the newest major. Each line's PHP range, `illuminate/*` constraint, and tools follow the Pharaonic Laravel line table. `6.x` runs PHPUnit; later lines run Pest.

## Core library

Number and byte formatting lives in `pharaonic/php-readable`. Fix formatting bugs there first, then raise this package's `~8.N.p` floor on every affected line. Dates and durations are formatted with Carbon through Laravel.

## Public API invariants

Configuration keys (`pharaonic.readable.*`), publish tags, and registered Blade, Artisan, macro, and validation names are public API.

- The package has no configuration, publishable resources, or translations.
- Canonical names: `Readable::get*()` methods, `snake_case` global helpers (`readable_number()`), and camelCase Blade directives (`@readableNumber`).
- The 1.x names (`getHumanNumber()`, `ReadableNumber()`, `@ReadableNumber`, …) are deprecated aliases with their 1.x signatures, including parameter names. They stay on every existing line and are removed only in the first line that supports PHP 8.6.
- Blade directives are registered by `BladeDirectives`, not inline in the provider, and echo the result unescaped, as in 1.x.
- `Readable` is registered as an alias of `Pharaonic\Laravel\Readable\Readable` through `extra.laravel.aliases`.
- Global helpers are declared only when a function with the same name does not exist.

## Package-specific constraints

- Outputs that were wrong in 1.x are fixed; formatting choices that were valid in 1.x are kept. Every fixed value is listed old → new in `tests/Unit/LegacyFixesTest.php` and in the changelog.
- `tests/Compatibility` pins the 1.x behavior that is kept.
- `ext-intl` is optional: only non-English `getNumberInWords()` needs it. CI runs one job without intl.

## Branch notes

Fixes land on the oldest affected line and are ported to every later line and `develop`.

## Documentation

https://pharaonic.dev/packages/laravel/readable

Keep this file factual and package-specific. General Pharaonic engineering policy belongs in the private engineering repository, not here.
