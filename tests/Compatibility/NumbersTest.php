<?php

use Pharaonic\Laravel\Readable\Readable;

// Legacy (1.x) number behavior kept in 6.x. Corrected values live in LegacyFixesTest.

dataset('invalid numbers', [
    'numeric string' => ['7'],
    'null' => [null],
    'empty string' => [''],
    'array' => [[]],
    'bool' => [true],
]);

test('getNumber', function (string $expected, int $input, string $delimiter = ',') {
    expect(Readable::getNumber($input, $delimiter))->toBe($expected);
})->with([
    'zero' => ['0', 0],
    'small' => ['999', 999],
    'thousand' => ['1,000', 1000],
    'readme' => ['10,203,040', 10203040],
    'negative' => ['-1,234,567', -1234567],
    'space delimiter' => ['1 234 567', 1234567, ' '],
    'empty delimiter' => ['1234567', 1234567, ''],
    'dot delimiter' => ['1.234.567', 1234567, '.'],
]);

test('getNumber coerces numeric strings', function () {
    expect(Readable::getNumber('12'))->toBe('12');
});

test('getNumber rejects null', function () {
    Readable::getNumber(null);
})->throws(TypeError::class);

test('getHumanNumber', function (string $expected, array $arguments) {
    expect(Readable::getHumanNumber(...$arguments))->toBe($expected);
})->with([
    'zero' => ['0', [0]],
    'zero ignores decimals' => ['0', [0, true, 2]],
    'below thousand' => ['999', [999]],
    'thousand' => ['1K', [1000]],
    'floors without decimals' => ['1K', [1500]],
    'floors to K' => ['77K', [77700]],
    'show decimal defaults to 1' => ['77.7K', [77700, true]],
    'readme' => ['77.7K', [77700, true, 1]],
    'two decimals' => ['77.75K', [77749, true, 2]],
    'floors near million' => ['999K', [999999]],
    'million' => ['1M', [1000000]],
    'million decimal' => ['1.3M', [1250000, true]],
    'billion' => ['2.00B', [1999999999, true, 2]],
    'trillion' => ['1T', [1000000000000]],
    'beyond trillion' => ['9,223,372T', [PHP_INT_MAX]],
    'decimals apply without show decimal' => ['77.00K', [77700, false, 2]],
]);

test('getDecimal', function (string $expected, array $arguments) {
    expect(Readable::getDecimal(...$arguments))->toBe($expected);
})->with([
    'readme' => ['60,708.54', [60708.54]],
    'rounds half up' => ['60,708.55', [60708.546]],
    'integer' => ['7.00', [7]],
    'zero' => ['0.00', [0]],
    'negative' => ['-1,234.50', [-1234.5]],
    'large' => ['100,000,000,000,000,000,000.00', [1e20]],
    'custom separators' => ['1.234,568', [1234.5678, 3, ',', '.']],
    'no decimals' => ['1,235', [1234.5, 0]],
    'negative decimals' => ['1,235', [1234.5, -1]],
]);

test('getDecimal rejects non-numbers', function ($input) {
    Readable::getDecimal($input);
})->with('invalid numbers')->throws(TypeError::class, 'Wrong Input Type.');

test('getDecInt', function (string $expected, array $arguments) {
    expect(Readable::getDecInt(...$arguments))->toBe($expected);
})->with([
    'whole float' => ['70', [70.0]],
    'fraction' => ['70.07', [70.07]],
    'rounds fraction' => ['70.01', [70.005]],
    'integer' => ['70', [70]],
    'integer ignores length' => ['70', [70, 3]],
    'negative whole float' => ['-3', [-3.0]],
    'negative fraction' => ['-3.50', [-3.5]],
    'grouped whole float' => ['1,234,567', [1234567.0]],
    'zero float' => ['0', [0.0]],
    'zero length' => ['1,235', [1234.5, 0]],
    'custom separators' => ['1.234,568', [1234.5678, 3, ',', '.']],
]);

test('getDecInt rejects non-numbers', function ($input) {
    Readable::getDecInt($input);
})->with('invalid numbers')->throws(TypeError::class, 'Wrong Input Type.');

test('getNumberToString', function (string $expected, array $arguments) {
    $this->requiresIntl();

    expect(Readable::getNumberToString(...$arguments))->toBe($expected);
})->with([
    'readme' => ['seven thousand seven hundred twenty-one', [7721]],
    'zero' => ['zero', [0]],
    'negative' => ['minus fifteen', [-15]],
    'float' => ['one point five', [1.5]],
    'small float' => ['zero point one', [0.1]],
    'million' => ['one million', [1000000]],
    'french' => ['vingt-et-un', [21, 'fr']],
    'arabic joins the conjunction' => ['واحد وعشرون', [21, 'ar']],
    'arabic region keeps the space' => ['واحد و عشرون', [21, 'ar_EG']],
]);

test('getNumberToString rejects non-numbers', function ($input) {
    Readable::getNumberToString($input);
})->with('invalid numbers')->throws(TypeError::class, 'Wrong Input Type.');
