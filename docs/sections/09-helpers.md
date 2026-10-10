## Helpers

Every static method has a global helper with the same arguments. Helpers are loaded through Composer, so they work anywhere: controllers, jobs, mail, Blade `{{ }}` echoes.

```php title="app/Notifications/ExportReady.php"
public function toMail($notifiable)
{
    return (new MailMessage)
        ->line('Your export is ready: '.ReadableSize($this->export->size).'.')
        ->line('It contains '.ReadableNumber($this->export->rows).' rows.');
}
```

| Helper | Same as |
| --- | --- |
| `ReadableNumber(int $input, string $delimiter = ',')` | `Readable::getNumber()` |
| `ReadableHumanNumber(int $input, bool $showDecimal = false, int $decimals = 0)` | `Readable::getHumanNumber()` |
| `ReadableNumberToString($input, string $lang = 'en')` | `Readable::getNumberToString()` |
| `ReadableDecimal($input, int $decimals = 2, string $point = '.', string $delimiter = ',')` | `Readable::getDecimal()` |
| `ReadableDecInt($input, int $decimals_length = 2, string $point = '.', string $delimiter = ',')` | `Readable::getDecInt()` |
| `ReadableDate($input, ?string $timezone = null)` | `Readable::getDate()` |
| `ReadableTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `Readable::getTime()` |
| `ReadableDateTime($input, $is12 = false, bool $hasSeconds = false, ?string $timezone = null)` | `Readable::getDateTime()` |
| `ReadableDiffDateTime($old, $new = null, ?string $timezone = null)` | `Readable::getDiffDateTime()` |
| `ReadableTimeLength(int $input, string $comma = ' ', bool $short = false)` | `Readable::getTimeLength()` |
| `ReadableDateTimeLength($old, $new = null, bool $full = false, string $comma = ' ', ?string $timezone = null)` | `Readable::getDateTimeLength()` |
| `ReadableSize(int $bytes, bool $decimal = true)` | `Readable::getSize()` |

:::info Name Clashes
Each helper is declared only if no function with that name exists yet, so a helper you define first wins.
:::
