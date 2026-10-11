:::badges
- Laravel Package {color=blue}
- {release.label} {color=green}
- {package.license} License {color=purple}
:::

# Laravel Readable

Laravel Readable turns raw values into text people can read: numbers with thousands separators or `K`/`M`/`B` suffixes, numbers in words, dates, times, date differences, durations and file sizes. Every formatter is available as a static method, a global helper and a Blade directive. Number grouping, spelling and byte sizes come from [PHP Readable](https://github.com/Pharaonic/php-readable), and dates and durations from Carbon, so they follow your application locale.

:::features
### Readable Numbers {icon="chart"}
10203040 becomes 10,203,040, and 77700 becomes 77K or 77.7K.

### Numbers in Words {icon="translate"}
7721 becomes seven thousand seven hundred twenty-one, in English or any intl language.

### Dates and Times {icon="clock"}
Print 24 April 2020, 03:20 PM or a full date and time, in any timezone.

### Date Differences {icon="arrow-long-right"}
Print 29 years before, or every unit between two dates.

### Durations {icon="lines"}
7777777 seconds becomes 3 months 29 minutes 37 seconds, or 3mos 29m 37s.

### File Sizes {icon="folder"}
1500 bytes becomes 1.5 KB, and 7168 bytes becomes 7 KiB.
:::

:::info Quick Tip
Directives, helpers and methods share one implementation. `@readableFileSize($bytes)`, `readable_file_size($bytes)` and `Readable::getFileSize($bytes)` always print the same thing.
:::
