## Upgrading from 1.x

Every 1.x method, helper, Blade directive and the `Readable` alias keep their names and signatures, and every correct 1.x output is unchanged. The upgrade fixes values that 1.x got wrong.

### Requirements

6.x requires PHP 8.0 and Laravel 6.20+. The package now depends on `illuminate/support`, `illuminate/view` and `pharaonic/php-readable` instead of `laravel/framework`.

### Fixed Values

| Call | 1.x | 6.x |
| --- | --- | --- |
| `getNumber(PHP_INT_MAX)` | `9,223,372,036,854,775,808` | `9,223,372,036,854,775,807` |
| `getHumanNumber(999999, true)` | `1,000.0K` | `1.0M` |
| `getHumanNumber(-1500)` | `ErrorException` | `-1K` |
| `getDecInt(69.999)` | `70.00` | `70` |
| `getNumberToString(21, 'ar_EG')` | `واحد و عشرون` | `واحد وعشرون` |
| `getTimeLength(0)` | `1 second` | `0 seconds` |
| `getTimeLength(31536000)` | `1 year 5 days` | `1 year` |
| `getTimeLength(-60)` | `11 months 4 weeks 1 day 23 hours 59 minutes` | `1 minute` |
| `getSize(0)` | `null` | `0 B` |
| `getSize(999999)` | `1000 KB` | `1 MB` |
| `getSize(4865)` | `4.86 KB` | `4.87 KB` |
| `getSize(10 ** 15)` | `ErrorException` | `1 PB` |

Passing a Carbon instance with a timezone no longer changes your instance:

```php
$date = Carbon::parse('2020-04-24 23:30:00', 'UTC');

Readable::getDate($date, 'Asia/Riyadh'); // "25 April 2020"
$date->tzName;                           // "UTC" (1.x: "Asia/Riyadh")
```

### Other Changes

- `getNumberToString()` spells English without the intl extension. Other languages throw `MissingIntlExtension` when intl is missing.
- `getNumberToString(INF)` and `getNumberToString(NAN)` throw `InvalidArgumentException` (1.x printed `infinity` and `not a number`).
- `getTimeLength()` counts a year as 365 days (it was 360). A month is still 30 days.
- Binary sizes between 1000 and 1023 units are grouped: `1,000 KiB`.
- `Readable::prepareDateTime()` also returns the prepared instance.
- Global helpers are declared only when a function with the same name doesn't already exist.

:::info Unchanged on Purpose
`getHumanNumber()` still truncates without decimals (`77700` → `77K`), `getSize()` still returns `null` for negative sizes, and Blade directives still echo without escaping.
:::
