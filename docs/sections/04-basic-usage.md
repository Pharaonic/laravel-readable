## Basic Usage

Each formatter can be called three ways, with the same arguments and the same result.

```php title="app/Http/Controllers/FileController.php"
use Pharaonic\Laravel\Readable\Readable;

Readable::getFileSize(1500);  // "1.5 KB"
readable_file_size(1500);       // "1.5 KB"
```

```blade title="resources/views/files/show.blade.php"
@readableFileSize(1500) {{-- 1.5 KB --}}
```

The `Readable` alias works too, without an import:

```php
\Readable::getNumber(10203040); // "10,203,040"
```

### Naming

| Static method | Helper | Blade directive |
| --- | --- | --- |
| `Readable::getNumber()` | `readable_number()` | `@readableNumber()` |
| `Readable::getCompactNumber()` | `readable_compact_number()` | `@readableCompactNumber()` |
| `Readable::getNumberInWords()` | `readable_number_in_words()` | `@readableNumberInWords()` |
| `Readable::getDecimal()` | `readable_decimal()` | `@readableDecimal()` |
| `Readable::getDecimalOrInteger()` | `readable_decimal_or_integer()` | `@readableDecimalOrInteger()` |
| `Readable::getDate()` | `readable_date()` | `@readableDate()` |
| `Readable::getTime()` | `readable_time()` | `@readableTime()` |
| `Readable::getDateTime()` | `readable_date_time()` | `@readableDateTime()` |
| `Readable::getRelativeDateTime()` | `readable_relative_date_time()` | `@readableRelativeDateTime()` |
| `Readable::getDuration()` | `readable_duration()` | `@readableDuration()` |
| `Readable::getDateTimeLength()` | `readable_date_time_length()` | `@readableDateTimeLength()` |
| `Readable::getFileSize()` | `readable_file_size()` | `@readableFileSize()` |
