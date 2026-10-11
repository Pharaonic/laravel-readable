## Durations

`getDuration($seconds, $separator = ' ', $short = false)` turns a number of seconds into a duration.

```php
Readable::getDuration(3661);               // "1 hour 1 minute 1 second"
Readable::getDuration(7777777);            // "3 months 29 minutes 37 seconds"
Readable::getDuration(7777777, ', ');      // "3 months, 29 minutes, 37 seconds"
Readable::getDuration(7777777, ' ', true); // "3mos 29m 37s"
Readable::getDuration(1558800);            // "2 weeks 4 days 1 hour"
Readable::getDuration(0);                  // "0 seconds"
```

A year is 365 days and a month is 30 days. Units with a zero value are skipped, and the sign is ignored (`-60` is `1 minute`).

:::tip Between Two Dates
To measure the time between two dates with calendar months and years, use [`getDateTimeLength()`](#dates) instead.
:::
