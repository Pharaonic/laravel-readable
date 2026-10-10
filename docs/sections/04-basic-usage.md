## Basic Usage

Each formatter can be called three ways, with the same arguments and the same result.

```php title="app/Http/Controllers/FileController.php"
use Pharaonic\Laravel\Readable\Readable;

Readable::getSize(1500);  // "1.5 KB"
ReadableSize(1500);       // "1.5 KB"
```

```blade title="resources/views/files/show.blade.php"
@ReadableSize(1500) {{-- 1.5 KB --}}
```

The `Readable` alias works too, without an import:

```php
\Readable::getNumber(10203040); // "10,203,040"
```

### Naming

| Static method | Helper | Blade directive |
| --- | --- | --- |
| `Readable::getNumber()` | `ReadableNumber()` | `@ReadableNumber()` |
| `Readable::getHumanNumber()` | `ReadableHumanNumber()` | `@ReadableHumanNumber()` |
| `Readable::getNumberToString()` | `ReadableNumberToString()` | `@ReadableNumberToString()` |
| `Readable::getDecimal()` | `ReadableDecimal()` | `@ReadableDecimal()` |
| `Readable::getDecInt()` | `ReadableDecInt()` | `@ReadableDecInt()` |
| `Readable::getDate()` | `ReadableDate()` | `@ReadableDate()` |
| `Readable::getTime()` | `ReadableTime()` | `@ReadableTime()` |
| `Readable::getDateTime()` | `ReadableDateTime()` | `@ReadableDateTime()` |
| `Readable::getDiffDateTime()` | `ReadableDiffDateTime()` | `@ReadableDiffDateTime()` |
| `Readable::getTimeLength()` | `ReadableTimeLength()` | `@ReadableTimeLength()` |
| `Readable::getDateTimeLength()` | `ReadableDateTimeLength()` | `@ReadableDateTimeLength()` |
| `Readable::getSize()` | `ReadableSize()` | `@ReadableSize()` |
