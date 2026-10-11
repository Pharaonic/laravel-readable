## File Sizes

`getFileSize($bytes, $decimal = true)` formats a byte count with up to 2 decimals, dropping trailing zeros.

```php
Readable::getFileSize(1500);              // "1.5 KB"
Readable::getFileSize(123456789);         // "123.46 MB"
Readable::getFileSize(999999);            // "1 MB"
Readable::getFileSize(0);                 // "0 B"
Readable::getFileSize(-1);                // null
```

By default 1 KB is 1000 bytes. Pass `false` for binary units, where 1 KiB is 1024 bytes:

```php
Readable::getFileSize(7168, false);       // "7 KiB"
Readable::getFileSize(123456789, false);  // "117.74 MiB"
Readable::getFileSize(1048576, false);    // "1 MiB"
```

| Mode | Units |
| --- | --- |
| Decimal (default) | `B`, `KB`, `MB`, `GB`, `TB`, `PB`, `EB`, `ZB`, `YB` |
| Binary | `B`, `KiB`, `MiB`, `GiB`, `TiB`, `PiB`, `EiB`, `ZiB`, `YiB` |

The value moves to the next unit when rounding reaches it, so `999999` is `1 MB`, not `1000 KB`.
