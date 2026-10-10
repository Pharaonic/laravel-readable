<?php

namespace Pharaonic\Laravel\Readable\Tests\Compatibility;

use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\Tests\TestCase;
use TypeError;

/**
 * Legacy (1.x) number behavior kept in 6.x. Corrected values live in LegacyFixesTest.
 */
class NumbersTest extends TestCase
{
    /**
     * @dataProvider numbers
     */
    public function test_get_number(string $expected, int $input, string $delimiter = ','): void
    {
        $this->assertSame($expected, Readable::getNumber($input, $delimiter));
    }

    public static function numbers(): array
    {
        return [
            'zero' => ['0', 0],
            'small' => ['999', 999],
            'thousand' => ['1,000', 1000],
            'readme' => ['10,203,040', 10203040],
            'negative' => ['-1,234,567', -1234567],
            'space delimiter' => ['1 234 567', 1234567, ' '],
            'empty delimiter' => ['1234567', 1234567, ''],
            'dot delimiter' => ['1.234.567', 1234567, '.'],
        ];
    }

    public function test_get_number_coerces_numeric_strings(): void
    {
        $this->assertSame('12', Readable::getNumber('12'));
    }

    public function test_get_number_rejects_null(): void
    {
        $this->expectException(TypeError::class);

        Readable::getNumber(null);
    }

    /**
     * @dataProvider humanNumbers
     */
    public function test_get_human_number(string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getHumanNumber(...$arguments));
    }

    public static function humanNumbers(): array
    {
        return [
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
        ];
    }

    /**
     * @dataProvider decimals
     */
    public function test_get_decimal(string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getDecimal(...$arguments));
    }

    public static function decimals(): array
    {
        return [
            'readme' => ['60,708.54', [60708.54]],
            'rounds half up' => ['60,708.55', [60708.546]],
            'integer' => ['7.00', [7]],
            'zero' => ['0.00', [0]],
            'negative' => ['-1,234.50', [-1234.5]],
            'large' => ['100,000,000,000,000,000,000.00', [1e20]],
            'custom separators' => ['1.234,568', [1234.5678, 3, ',', '.']],
            'no decimals' => ['1,235', [1234.5, 0]],
            'negative decimals' => ['1,235', [1234.5, -1]],
        ];
    }

    /**
     * @dataProvider invalidNumbers
     */
    public function test_get_decimal_rejects_non_numbers($input): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Wrong Input Type.');

        Readable::getDecimal($input);
    }

    /**
     * @dataProvider decInts
     */
    public function test_get_dec_int(string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getDecInt(...$arguments));
    }

    public static function decInts(): array
    {
        return [
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
        ];
    }

    /**
     * @dataProvider invalidNumbers
     */
    public function test_get_dec_int_rejects_non_numbers($input): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Wrong Input Type.');

        Readable::getDecInt($input);
    }

    /**
     * @dataProvider spelledNumbers
     */
    public function test_get_number_to_string(string $expected, array $arguments): void
    {
        $this->requiresIntl();

        $this->assertSame($expected, Readable::getNumberToString(...$arguments));
    }

    public static function spelledNumbers(): array
    {
        return [
            'readme' => ['seven thousand seven hundred twenty-one', [7721]],
            'zero' => ['zero', [0]],
            'negative' => ['minus fifteen', [-15]],
            'float' => ['one point five', [1.5]],
            'small float' => ['zero point one', [0.1]],
            'million' => ['one million', [1000000]],
            'french' => ['vingt-et-un', [21, 'fr']],
            'arabic joins the conjunction' => ['واحد وعشرون', [21, 'ar']],
            'arabic region keeps the space' => ['واحد و عشرون', [21, 'ar_EG']],
        ];
    }

    /**
     * @dataProvider invalidNumbers
     */
    public function test_get_number_to_string_rejects_non_numbers($input): void
    {
        $this->expectException(TypeError::class);
        $this->expectExceptionMessage('Wrong Input Type.');

        Readable::getNumberToString($input);
    }

    public static function invalidNumbers(): array
    {
        return [
            'numeric string' => ['7'],
            'null' => [null],
            'empty string' => [''],
            'array' => [[]],
            'bool' => [true],
        ];
    }
}
