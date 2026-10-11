<?php

namespace Pharaonic\Laravel\Readable\Tests\Compatibility;

use Illuminate\Support\Facades\Blade;
use Pharaonic\Laravel\Readable\Tests\TestCase;

/**
 * Deprecated 1.x Blade directives. They compile to the canonical methods and echo the raw (unescaped) result.
 */
class BladeTest extends TestCase
{
    /**
     * @dataProvider directives
     */
    public function test_directive_compiles_to_the_canonical_static_call(string $directive, string $method): void
    {
        $this->assertSame(
            "<?php echo Pharaonic\\Laravel\\Readable\\Readable::{$method}(\$value, 1); ?>",
            Blade::compileString("@{$directive}(\$value, 1)")
        );
    }

    public static function directives(): array
    {
        return [
            ['ReadableNumber', 'getNumber'],
            ['ReadableHumanNumber', 'getCompactNumber'],
            ['ReadableNumberToString', 'getNumberInWords'],
            ['ReadableDecimal', 'getDecimal'],
            ['ReadableDecInt', 'getDecimalOrInteger'],
            ['ReadableDate', 'getDate'],
            ['ReadableTime', 'getTime'],
            ['ReadableDateTime', 'getDateTime'],
            ['ReadableDiffDateTime', 'getRelativeDateTime'],
            ['ReadableTimeLength', 'getDuration'],
            ['ReadableDateTimeLength', 'getDateTimeLength'],
            ['ReadableSize', 'getFileSize'],
        ];
    }

    /**
     * @dataProvider renders
     */
    public function test_directive_renders(string $expected, string $template, array $data = []): void
    {
        $this->assertSame($expected, $this->render($template, $data));
    }

    public static function renders(): array
    {
        return [
            'number' => ['10,203,040', '@ReadableNumber(10203040)'],
            'number with delimiter' => ['1 234', "@ReadableNumber(1234, ' ')"],
            'human number' => ['77.7K', '@ReadableHumanNumber(77700, true, 1)'],
            'decimal' => ['60,708.54', '@ReadableDecimal($n)', ['n' => 60708.54]],
            'dec int' => ['70', '@ReadableDecInt(70.0)'],
            'date' => ['24 April 2020', "@ReadableDate('24-04-2020')"],
            'null date is now' => ['15 January 2026', '@ReadableDate(null)'],
            'time' => ['03:20 PM', "@ReadableTime('15:20:22', true)"],
            'date time' => ['Friday, April 24, 2020 05:20:30 PM', "@ReadableDateTime('24-04-2020 17:20:30', true, true)"],
            'diff' => ['29 years before', "@ReadableDiffDateTime('01-02-1993 19:00:00', '01-02-2022 19:00:00')"],
            'time length' => ['3 months 29 minutes 37 seconds', '@ReadableTimeLength(7777777)'],
            'date time length' => ['29 years before', "@ReadableDateTimeLength('01-02-1993 19:00:00', '01-02-2022 19:00:00')"],
            'size' => ['7 KiB', '@ReadableSize(7168, false)'],
            'negative size prints nothing' => ['[]', '[@ReadableSize(-1)]'],
            'output is not escaped' => ['1<b>000', "@ReadableNumber(1000, '<b>')"],
            'inline with text' => ['Size: 1.5 KB.', 'Size: @ReadableSize(1500).'],
        ];
    }

    public function test_number_to_string_directive_renders(): void
    {
        $this->requiresIntl();

        $this->assertSame('seven thousand seven hundred twenty-one', $this->render('@ReadableNumberToString(7721)'));
    }

    public function test_directive_without_arguments_compiles_to_an_empty_call(): void
    {
        $this->assertSame(
            '<?php echo Pharaonic\Laravel\Readable\Readable::getDate(); ?>',
            Blade::compileString('@ReadableDate')
        );
    }

    private function render(string $template, array $data = []): string
    {
        $path = tempnam(sys_get_temp_dir(), 'readable').'.blade.php';
        file_put_contents($path, $template);

        try {
            return view()->file($path, $data)->render();
        } finally {
            unlink($path);
        }
    }
}
