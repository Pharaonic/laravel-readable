## Dates & Times

Date methods accept anything `Carbon::parse()` understands: date strings, Unix timestamps, `DateTime` and Carbon instances. `null` means now. The optional `$timezone` converts the date before formatting, without changing your instance.

### Date

```php
Readable::getDate('24-04-2020');                            // "24 April 2020"
Readable::getDate($post->created_at);                       // "24 April 2020"
Readable::getDate('2020-04-24 23:30:00', 'Asia/Riyadh');    // "25 April 2020"
```

### Time

`getTime($input, $is12 = false, $hasSeconds = false, $timezone = null)`:

```php
Readable::getTime('15:20:22');               // "15:20"
Readable::getTime('15:20:22', false, true);  // "15:20:22"
Readable::getTime('15:20:22', true);         // "03:20 PM"
Readable::getTime('15:20:22', true, true);   // "03:20:22 PM"
Readable::getTime('2020-01-01 15:20', false, false, 'Africa/Cairo'); // "17:20"
```

### Date and Time

`getDateTime()` takes the same arguments as `getTime()`:

```php
Readable::getDateTime('24-04-2020 17:20:30');             // "Friday, April 24, 2020 17:20"
Readable::getDateTime('24-04-2020 17:20:30', true);       // "Friday, April 24, 2020 05:20 PM"
Readable::getDateTime('24-04-2020 17:20:30', true, true); // "Friday, April 24, 2020 05:20:30 PM"
```

### Difference

`getRelativeDateTime($date, $other = null, $timezone = null)` prints the largest unit between two dates. Without `$other`, it compares with now.

```php
Readable::getRelativeDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'); // "29 years before"
Readable::getRelativeDateTime('2022-01-01', '1993-01-01');                   // "29 years after"
Readable::getRelativeDateTime(now()->subHour());                             // "1 hour before"
```

### Full Difference

`getDateTimeLength($old, $new = null, $full = false, $comma = ' ', $timezone = null)` prints every unit when `$full` is `true`, joined by `$comma`.

```php
Readable::getDateTimeLength('1993-01-02 19:00:00', '2022-03-05 20:07:07');
// "29 years before"

Readable::getDateTimeLength('1993-01-02 19:00:00', '2022-03-05 20:07:07', true);
// "29 years 2 months 3 days 1 hour 7 minutes 7 seconds before"

Readable::getDateTimeLength('1993-01-02 19:00:00', '2022-03-05 20:07:07', true, ' - ');
// "29 years - 2 months - 3 days - 1 hour - 7 minutes - 7 seconds before"
```

:::info Translations
Month names, day names, `AM`/`PM` and words such as `years` and `before` come from Carbon, which follows `app()->setLocale()`.
:::
