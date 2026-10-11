## Troubleshooting

### `TypeError: Wrong Input Type.`

`getDecimal()`, `getDecimalOrInteger()` and `getNumberInWords()` accept only `int` and `float`. Database columns such as `decimal` come back as strings, so cast them: `readable_decimal((float) $order->total)`.

### `MissingIntlExtension` when spelling a number

You passed a language other than `en` to `getNumberInWords()` and the intl extension isn't installed. Install `ext-intl`, or use English.

### Dates are in English although my app is in another language

Carbon follows `app()->setLocale()`. Set the locale before rendering, for example in a middleware, and make sure Carbon has a translation for it.

### The time is off by a few hours

The input is parsed in the application timezone (`config/app.php` → `timezone`). Pass the viewer's timezone as the last argument, such as `readable_time($date, true, false, 'Africa/Cairo')`.

### `@readableDate` throws `Too few arguments`

The directive needs at least one argument. Use `@readableDate(null)` for today's date.

### `@readableFileSize` prints nothing

The size is negative. `getFileSize()` returns `null` for negative sizes, and `0` prints `0 B`.

### A helper does something different

Another package or your app declared a function with the same name first, for example `readable_file_size()`. Call the static method instead: `Readable::getFileSize()`.
