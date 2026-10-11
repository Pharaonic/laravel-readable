## Helpers

Every static method except `prepareDateTime()` has a `snake_case` global helper with the same arguments. Helpers are loaded through Composer, so they work anywhere: controllers, jobs, mail, Blade `{{ }}` echoes.

```php title="app/Notifications/ExportReady.php"
public function toMail($notifiable)
{
    return (new MailMessage)
        ->line('Your export is ready: '.readable_file_size($this->export->size).'.')
        ->line('It contains '.readable_number($this->export->rows).' rows.');
}
```

| Helper | Same as |
| --- | --- |
| `readable_number(int $input, string $delimiter = ',')` | `Readable::getNumber()` |
| `readable_compact_number(int $input, bool $showDecimal = false, int $decimals = 0)` | `Readable::getCompactNumber()` |
| `readable_number_in_words($input, string $locale = 'en')` | `Readable::getNumberInWords()` |
| `readable_decimal($input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | `Readable::getDecimal()` |
| `readable_decimal_or_integer($input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | `Readable::getDecimalOrInteger()` |
| `readable_date($input, ?string $timezone = null)` | `Readable::getDate()` |
| `readable_time($input, bool $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `Readable::getTime()` |
| `readable_date_time($input, bool $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `Readable::getDateTime()` |
| `readable_relative_date_time($date, $other = null, ?string $timezone = null)` | `Readable::getRelativeDateTime()` |
| `readable_duration(int $seconds, string $separator = ' ', bool $short = false)` | `Readable::getDuration()` |
| `readable_date_time_length($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null)` | `Readable::getDateTimeLength()` |
| `readable_file_size(int $bytes, bool $decimal = true)` | `Readable::getFileSize()` |

:::info Name Clashes
Each helper is declared only if no function with that name exists yet, so a helper you define first wins.
:::
