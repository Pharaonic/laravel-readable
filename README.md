<p align="center"><a href="https://pharaonic.dev/packages/laravel/readable" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/logos/main/readable.jpg"></a></p>

<p align="center">
  <a href="https://php.net" target="_blank"><img src="https://img.shields.io/static/v1?label=PHP&message=8.0&color=blue&style=flat-square" alt="PHP Version : 8.0"></a>
  <a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/static/v1?label=Laravel&message=6.x&color=F05340&style=flat-square" alt="Laravel Version : 6.x"></a>
  <img src="https://img.shields.io/static/v1?label=License&message=MIT&color=brightgreen&style=flat-square" alt="License">
  <img src="https://github.com/Pharaonic/laravel-readable/actions/workflows/build.yml/badge.svg?branch=6.x" alt="Build">
  <br>
  <a href="https://packagist.org/packages/Pharaonic/laravel-readable" target="_blank"><img src="https://img.shields.io/static/v1?label=Packagist&message=pharaonic/laravel-readable&color=blue&logo=packagist&logoColor=white" alt="Source"></a>
  <a href="https://packagist.org/packages/pharaonic/laravel-readable" target="_blank"><img src="https://poser.pugx.org/pharaonic/laravel-readable/v" alt="Packagist Version"></a>
  <a href="https://packagist.org/packages/pharaonic/laravel-readable" target="_blank"><img src="https://poser.pugx.org/pharaonic/laravel-readable/downloads" alt="Packagist Downloads"></a>
</p>

<h3 align="center">Readable numbers, dates, durations and file sizes for Laravel.</h3>
<h5 align="center">Powered by <a href="https://pharaonic.dev/packages/php/readable" target="_blank">PHP Readable</a> and Carbon.</h5>
<br>

## Requirements

- PHP 8.0
- Laravel 6.20 or newer within 6.x
- `pharaonic/php-readable` 8.0.1+ within 8.0.x (installed automatically)
- `ext-intl` only for `getNumberToString()` in a language other than English

## Installation

```bash
composer require pharaonic/laravel-readable
```

Laravel discovers the service provider and the `Readable` alias automatically. There is no configuration.

## Usage

Every feature is available three ways: a static method, a global helper and a Blade directive.

```php
use Pharaonic\Laravel\Readable\Readable;

Readable::getNumber(10203040);   // "10,203,040"
ReadableNumber(10203040);        // "10,203,040"
```

```blade
@ReadableNumber(10203040)
```

Blade directives echo the result as is (unescaped), so they behave like `{!! !!}`.

### Numbers

| Method | Helper / directive | Example |
|---|---|---|
| `getNumber(int $input, string $delimiter = ',')` | `ReadableNumber` | `10203040` → `10,203,040` |
| `getHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0)` | `ReadableHumanNumber` | `77700` → `77K`, `(77700, true)` → `77.7K` |
| `getNumberToString(int\|float $input, string $lang = 'en')` | `ReadableNumberToString` | `7721` → `seven thousand seven hundred twenty-one` |
| `getDecimal(int\|float $input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | `ReadableDecimal` | `60708.546` → `60,708.55` |
| `getDecInt(int\|float $input, int $decimals_length = 2, string $point = '.', string $delimiter = ',')` | `ReadableDecInt` | `70.0` → `70`, `70.07` → `70.07` |

- `getHumanNumber()` truncates to whole units without `$showDecimal` (`1500` → `1K`) and rounds with it (`999999, true` → `1.0M`).
- `getNumberToString()` spells English natively. Other languages use intl: `(21, 'fr')` → `vingt-et-un`, `(21, 'ar')` → `واحد وعشرون`.
- `getDecimal()`, `getDecInt()` and `getNumberToString()` accept only real integers and floats and throw `TypeError('Wrong Input Type.')` otherwise.

### Dates

Dates accept anything `Carbon::parse()` understands (strings, timestamps, `DateTime` and Carbon instances). `null` means now. An optional `$timezone` converts the date first. Your Carbon instance is never modified.

| Method | Helper / directive | Example |
|---|---|---|
| `getDate($input, ?string $timezone = null)` | `ReadableDate` | `'24-04-2020'` → `24 April 2020` |
| `getTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `ReadableTime` | `'15:20:22'` → `15:20`, `('15:20:22', true)` → `03:20 PM` |
| `getDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `ReadableDateTime` | `('24-04-2020 17:20:30', true, true)` → `Friday, April 24, 2020 05:20:30 PM` |
| `getDiffDateTime($old, $new = null, ?string $timezone = null)` | `ReadableDiffDateTime` | `('01-02-1993 19:00', '01-02-2022 19:00')` → `29 years before` |
| `getDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null)` | `ReadableDateTimeLength` | full → `29 years 2 months 3 days 1 hour 7 minutes 7 seconds before` |

Month names, day names and relative words follow Carbon's locale, which Laravel keeps in sync with the application locale.

### Durations

```php
Readable::getTimeLength(7777777);             // "3 months 29 minutes 37 seconds"
Readable::getTimeLength(7777777, ', ');       // "3 months, 29 minutes, 37 seconds"
Readable::getTimeLength(7777777, ' ', true);  // "3mos 29m 37s"
Readable::getTimeLength(0);                   // "0 seconds"
```

A year is 365 days and a month is 30 days. The sign is ignored.

### File sizes

```php
Readable::getSize(1500);           // "1.5 KB"   (1 KB = 1000 B)
Readable::getSize(7168, false);    // "7 KiB"    (1 KiB = 1024 B)
Readable::getSize(999999);         // "1 MB"
Readable::getSize(0);              // "0 B"
Readable::getSize(-1);             // null
```

### Helpers

`ReadableNumber`, `ReadableHumanNumber`, `ReadableNumberToString`, `ReadableDecimal`, `ReadableDecInt`, `ReadableDate`, `ReadableTime`, `ReadableDateTime`, `ReadableDiffDateTime`, `ReadableTimeLength`, `ReadableDateTimeLength` and `ReadableSize` take the same arguments as their `Readable::get*` method.

## Upgrading from 1.x

Every method, helper, directive and the `Readable` alias keep their names and signatures, and every correct 1.x output is unchanged. 6.0 fixes values that 1.x got wrong:

- `getNumber()` keeps full precision above 2^53.
- `getHumanNumber()` moves to the next unit when rounding reaches 1000 (`1,000.0K` → `1.0M`) and supports negative numbers.
- `getDecInt()` drops decimals that round away (`69.999` → `70`).
- `getNumberToString()` joins the Arabic conjunction for every Arabic locale (`ar_EG` too) and no longer needs intl for English.
- `getTimeLength()` prints `0 seconds` for zero, ignores the sign and counts a year as 365 days.
- `getSize()` returns `0 B` for zero, rounds half up, moves to the next unit (`1000 KB` → `1 MB`) and supports `PB` and above.
- Passing a Carbon instance with a timezone no longer changes your instance.

Number grouping, spelling and byte sizes now come from [`pharaonic/php-readable`](https://github.com/Pharaonic/php-readable), and dates and durations from Carbon. See [CHANGELOG.md](CHANGELOG.md) for each old and new value.

## Testing

```bash
composer check
```

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## Security

See [SECURITY.md](SECURITY.md).

## License

This package is an open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
