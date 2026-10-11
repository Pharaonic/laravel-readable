## Numbers

### Grouped Integers

`getNumber()` groups an integer's thousands. The second argument changes the delimiter.

```php
Readable::getNumber(10203040);       // "10,203,040"
Readable::getNumber(-1234567);       // "-1,234,567"
Readable::getNumber(1234567, ' ');   // "1 234 567"
Readable::getNumber(1234567, '.');   // "1.234.567"
Readable::getNumber(PHP_INT_MAX);    // "9,223,372,036,854,775,807"
```

### Short Numbers

`getCompactNumber()` shortens a number with a `K`, `M`, `B` or `T` suffix.

```php
Readable::getCompactNumber(999);              // "999"
Readable::getCompactNumber(77700);            // "77K"
Readable::getCompactNumber(77700, true);      // "77.7K"
Readable::getCompactNumber(77749, true, 2);   // "77.75K"
Readable::getCompactNumber(1250000, true);    // "1.3M"
Readable::getCompactNumber(999999, true);     // "1.0M"
Readable::getCompactNumber(-1500);            // "-1K"
```

Without `$showDecimal`, the value is truncated to whole units (`1500` → `1K`). With it, the value is rounded to `$decimals` places (1 by default) and moves to the next unit when rounding reaches 1000. Values past 999T keep the `T` suffix.

:::tip Fixed Decimals
`$decimals` always prints that many places, even when they are zeros: `getCompactNumber(1999999999, true, 2)` is `2.00B`.
:::

### Decimals

`getDecimal()` formats a number with a fixed number of decimals, rounding half up. You can change the decimal point and the thousands delimiter.

```php
Readable::getDecimal(60708.546);               // "60,708.55"
Readable::getDecimal(7);                       // "7.00"
Readable::getDecimal(1234.5678, 3, ',', '.');  // "1.234,568"
```

### Decimals Only When Needed

`getDecimalOrInteger()` prints integers, and floats that round to a whole number, without decimals.

```php
Readable::getDecimalOrInteger(70.0);    // "70"
Readable::getDecimalOrInteger(69.999);  // "70"
Readable::getDecimalOrInteger(70.07);   // "70.07"
Readable::getDecimalOrInteger(-3.5);    // "-3.50"
Readable::getDecimalOrInteger(70, 3);   // "70"
```

It takes the same `$point` and `$delimiter` arguments as `getDecimal()`.

### Numbers in Words

`getNumberInWords()` spells a number out. English is spelled natively. Any other language uses the intl extension.

```php
Readable::getNumberInWords(7721);       // "seven thousand seven hundred twenty-one"
Readable::getNumberInWords(-15);        // "minus fifteen"
Readable::getNumberInWords(1.5);        // "one point five"
Readable::getNumberInWords(21, 'fr');   // "vingt-et-un"
Readable::getNumberInWords(21, 'ar');   // "واحد وعشرون"
```

:::warning Strict Input
`getDecimal()`, `getDecimalOrInteger()` and `getNumberInWords()` accept only real integers and floats. A numeric string such as `'7'` throws `TypeError('Wrong Input Type.')`, so cast database strings first: `readable_decimal((float) $price)`.
:::
