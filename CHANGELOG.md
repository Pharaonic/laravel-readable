# Changelog

All notable changes to this project will be documented in this file.

## 8.0.0 - 2026-10-11

### Compatibility

- Laravel 8.75+ on PHP 8.0 or 8.1.
- Requires `pharaonic/php-readable` `~8.0.3` on PHP 8.0 or `~8.1.2` on PHP 8.1.
- The same API and outputs as 7.0.0, including the deprecated 1.x names.

## 7.0.0 - 2026-10-11

### Compatibility

- Laravel 7.30+ on PHP 8.0.
- Requires `pharaonic/php-readable` `~8.0.3`.
- The same API and outputs as 6.0.0, including the deprecated 1.x names.

## 6.0.0 - 2026-10-11

### Added

- `Readable::prepareDateTime()` also returns the prepared Carbon instance.
- `getSize()` supports petabytes and above (`PB`, `EB`, ... and `PiB`, `EiB`, ...).
- `getHumanNumber()` supports negative numbers (`-1500` → `-1K`).
- Compatibility, feature and unit test suites, PHPStan and Laravel Pint.
- GitHub community files, Dependabot and a PHP 8.0 lowest/highest CI matrix.
- Package documentation in `docs/` for pharaonic.dev.
- Canonical method names: `getCompactNumber()`, `getNumberInWords()`, `getDecimalOrInteger()`, `getRelativeDateTime()`, `getDuration()` and `getFileSize()`.
- `snake_case` global helpers for every method, such as `readable_number()` and `readable_file_size()`.
- camelCase Blade directives for every method, such as `@readableNumber` and `@readableFileSize`.

### Changed

- `getNumber()` and `getNumberToString()` delegate to `pharaonic/php-readable`, and so does `getSize()` for zero and positive sizes.
- `getNumberToString()` spells English without the intl extension. Other languages still need intl.
- `getTimeLength()` counts a year as 365 days (it was 360). A month is still 30 days.
- Dates are parsed with `Illuminate\Support\Carbon`, a subclass of `Carbon\Carbon`.
- Global helpers are declared only when the function does not already exist.
- The package requires `illuminate/support` and `illuminate/view` instead of `laravel/framework`.

### Deprecated

Each deprecated name still works and returns the same value. They are removed in the first line that supports PHP 8.6.

| Deprecated | Use |
|---|---|
| `getHumanNumber()` | `getCompactNumber()` |
| `getNumberToString()` | `getNumberInWords()` |
| `getDecInt()` | `getDecimalOrInteger()` |
| `getDiffDateTime()` | `getRelativeDateTime()` |
| `getTimeLength()` | `getDuration()` |
| `getSize()` | `getFileSize()` |
| `ReadableNumber()` and the other PascalCase helpers | `readable_number()` and the other `snake_case` helpers |
| `@ReadableNumber` and the other PascalCase directives | `@readableNumber` and the other camelCase directives |

### Fixed

Each value below was wrong in 1.x:

| Call | 1.x | 6.x |
|---|---|---|
| `getNumber(PHP_INT_MAX)` | `9,223,372,036,854,775,808` | `9,223,372,036,854,775,807` |
| `getHumanNumber(999999, true)` | `1,000.0K` | `1.0M` |
| `getHumanNumber(-1500)` | `ErrorException` | `-1K` |
| `getDecInt(69.999)` | `70.00` | `70` |
| `getNumberToString(21, 'ar_EG')` | `واحد و عشرون` | `واحد وعشرون` |
| `getNumberToString(PHP_INT_MAX)` | `9,223,372,036,854,775,807` | spelled out |
| `getTimeLength(0)` | `1 second` | `0 seconds` |
| `getTimeLength(31536000)` | `1 year 5 days` | `1 year` |
| `getTimeLength(-60)` | `11 months 4 weeks 1 day 23 hours 59 minutes` | `1 minute` |
| `getSize(0)` | `null` | `0 B` |
| `getSize(999999)` | `1000 KB` | `1 MB` |
| `getSize(4865)` | `4.86 KB` | `4.87 KB` |
| `getSize(10 ** 15)` | `ErrorException` | `1 PB` |

- Passing a Carbon instance with a timezone no longer changes the caller's instance.

### Compatibility

- Laravel 6.x on PHP 8.0.
- Requires `pharaonic/php-readable` `~8.0.3`.
- Every 1.x method, helper, Blade directive and the `Readable` alias keep their names and signatures.
- Every output not listed under Fixed is unchanged, including `getHumanNumber()` truncating without decimals (`77700` → `77K`), 30-day months in `getTimeLength()` and unescaped Blade output.
- `getNumberToString()` throws `InvalidArgumentException` for `INF` and `NAN` (1.x printed `infinity` and `not a number`), and `MissingIntlExtension` for a non-English language without intl.
- Binary sizes between 1000 and 1023 units are grouped (`1,000 KiB`).
- `getSize()` still returns `null` for negative sizes.
