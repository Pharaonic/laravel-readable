<?php

namespace Pharaonic\Laravel\Readable\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\Tests\TestCase;

/**
 * Canonical names, and the deprecated 1.x names that alias them.
 */
class CanonicalNamesTest extends TestCase
{
    /**
     * @dataProvider renamedMethods
     */
    public function test_deprecated_method_returns_the_canonical_result(string $deprecated, string $canonical, array $arguments): void
    {
        $this->assertSame(
            Readable::{$canonical}(...$arguments),
            Readable::{$deprecated}(...$arguments)
        );
    }

    public static function renamedMethods(): array
    {
        return [
            ['getHumanNumber', 'getCompactNumber', [77749, true, 2]],
            ['getDecInt', 'getDecimalOrInteger', [70.07]],
            ['getDiffDateTime', 'getRelativeDateTime', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
            ['getTimeLength', 'getDuration', [7777777, ', ', true]],
            ['getSize', 'getFileSize', [7168, false]],
        ];
    }

    public function test_deprecated_number_to_string_returns_the_canonical_result(): void
    {
        $this->assertSame('twenty-one', Readable::getNumberInWords(21));
        $this->assertSame(Readable::getNumberInWords(21), Readable::getNumberToString(21));
    }

    public function test_canonical_methods(): void
    {
        $this->assertSame('77K', Readable::getCompactNumber(77700));
        $this->assertSame('1.0M', Readable::getCompactNumber(999999, true));
        $this->assertSame('70', Readable::getDecimalOrInteger(69.999));
        $this->assertSame('1.234,57', Readable::getDecimalOrInteger(1234.567, 2, ',', '.'));
        $this->assertSame('29 years before', Readable::getRelativeDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00'));
        $this->assertSame('1 hour 1 minute 1 second', Readable::getDuration(3661));
        $this->assertSame('1h, 1m, 1s', Readable::getDuration(3661, ', ', true));
        $this->assertSame('1.5 KB', Readable::getFileSize(1500));
        $this->assertNull(Readable::getFileSize(-1));
    }

    public function test_canonical_methods_accept_named_arguments(): void
    {
        $this->assertSame('70.1', Readable::getDecimalOrInteger(70.07, decimals: 1));
        $this->assertSame('1m|1s', Readable::getDuration(61, separator: '|', short: true));
        $this->assertSame('twenty-one', Readable::getNumberInWords(21, locale: 'en'));
    }

    public function test_deprecated_methods_keep_their_1x_parameter_names(): void
    {
        $this->assertSame('70.1', Readable::getDecInt(70.07, decimals_length: 1));
        $this->assertSame('1m|1s', Readable::getTimeLength(61, comma: '|', short: true));
        $this->assertSame('twenty-one', Readable::getNumberToString(21, lang: 'en'));
    }

    /**
     * @dataProvider helpers
     */
    public function test_snake_case_helper_and_deprecated_helper_match_the_method(string $helper, string $deprecated, string $method, array $arguments): void
    {
        $expected = Readable::{$method}(...$arguments);

        $this->assertSame($expected, $helper(...$arguments));
        $this->assertSame($expected, $deprecated(...$arguments));
    }

    public static function helpers(): array
    {
        return [
            ['readable_number', 'ReadableNumber', 'getNumber', [1234, ' ']],
            ['readable_compact_number', 'ReadableHumanNumber', 'getCompactNumber', [77749, true, 2]],
            ['readable_number_in_words', 'ReadableNumberToString', 'getNumberInWords', [21]],
            ['readable_decimal', 'ReadableDecimal', 'getDecimal', [1234.5678, 3, ',', '.']],
            ['readable_decimal_or_integer', 'ReadableDecInt', 'getDecimalOrInteger', [70.07]],
            ['readable_date', 'ReadableDate', 'getDate', ['24-04-2020']],
            ['readable_time', 'ReadableTime', 'getTime', ['15:20:22', true, true]],
            ['readable_date_time', 'ReadableDateTime', 'getDateTime', ['24-04-2020 17:20:30', true]],
            ['readable_relative_date_time', 'ReadableDiffDateTime', 'getRelativeDateTime', ['01-02-1993 19:00:00', '01-02-2022 19:00:00']],
            ['readable_duration', 'ReadableTimeLength', 'getDuration', [7777777]],
            ['readable_date_time_length', 'ReadableDateTimeLength', 'getDateTimeLength', ['01-02-1993 19:00:00', '01-02-2022 19:00:00', true]],
            ['readable_file_size', 'ReadableSize', 'getFileSize', [7168, false]],
        ];
    }

    /**
     * @dataProvider directives
     */
    public function test_canonical_directive_compiles_to_the_canonical_static_call(string $directive, string $method): void
    {
        $this->assertSame(
            "<?php echo Pharaonic\\Laravel\\Readable\\Readable::{$method}(\$value, 1); ?>",
            Blade::compileString("@{$directive}(\$value, 1)")
        );
    }

    public static function directives(): array
    {
        return [
            ['readableNumber', 'getNumber'],
            ['readableCompactNumber', 'getCompactNumber'],
            ['readableNumberInWords', 'getNumberInWords'],
            ['readableDecimal', 'getDecimal'],
            ['readableDecimalOrInteger', 'getDecimalOrInteger'],
            ['readableDate', 'getDate'],
            ['readableTime', 'getTime'],
            ['readableDateTime', 'getDateTime'],
            ['readableRelativeDateTime', 'getRelativeDateTime'],
            ['readableDuration', 'getDuration'],
            ['readableDateTimeLength', 'getDateTimeLength'],
            ['readableFileSize', 'getFileSize'],
        ];
    }

    public function test_canonical_directive_renders_the_same_as_the_deprecated_one(): void
    {
        $this->assertSame('77.7K', $this->render('@readableCompactNumber(77700, true, 1)'));
        $this->assertSame($this->render('@ReadableHumanNumber(77700, true, 1)'), $this->render('@readableCompactNumber(77700, true, 1)'));
    }

    private function render(string $template): string
    {
        $path = tempnam(sys_get_temp_dir(), 'readable').'.blade.php';
        file_put_contents($path, $template);

        try {
            return view()->file($path)->render();
        } finally {
            unlink($path);
        }
    }
}
