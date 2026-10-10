<?php

namespace Pharaonic\Laravel\Readable\Tests\Compatibility;

use Pharaonic\Laravel\Readable\Readable;
use Pharaonic\Laravel\Readable\Tests\TestCase;

/**
 * Legacy (1.x) file size behavior kept in 6.x. Corrected values live in LegacyFixesTest.
 */
class SizesTest extends TestCase
{
    /**
     * @dataProvider sizes
     */
    public function test_get_size(?string $expected, array $arguments): void
    {
        $this->assertSame($expected, Readable::getSize(...$arguments));
    }

    public static function sizes(): array
    {
        return [
            'negative' => [null, [-1]],
            'one byte' => ['1 B', [1]],
            'bytes' => ['999 B', [999]],
            'kilobyte' => ['1 KB', [1000]],
            'kibibyte as decimal' => ['1.02 KB', [1024]],
            'fraction' => ['1.5 KB', [1500]],
            'rounds to 2 decimals' => ['1.54 KB', [1536]],
            'megabyte' => ['1 MB', [1000000]],
            'megabytes' => ['123.46 MB', [123456789]],
            'terabyte' => ['1 TB', [1000000000000]],
            'binary mebibyte' => ['1 MiB', [1048576, false]],
            'readme binary' => ['7 KiB', [7168, false]],
            'binary mebibytes' => ['117.74 MiB', [123456789, false]],
        ];
    }
}
