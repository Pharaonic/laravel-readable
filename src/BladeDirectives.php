<?php

namespace Pharaonic\Laravel\Readable;

use Illuminate\View\Compilers\BladeCompiler;

class BladeDirectives
{
    /**
     * Blade directive => Readable method.
     */
    private const DIRECTIVES = [
        // NUMBERS
        'readableNumber' => 'getNumber',
        'readableCompactNumber' => 'getCompactNumber',
        'readableNumberInWords' => 'getNumberInWords',
        'readableDecimal' => 'getDecimal',
        'readableDecimalOrInteger' => 'getDecimalOrInteger',

        // DATE & TIME
        'readableDate' => 'getDate',
        'readableTime' => 'getTime',
        'readableDateTime' => 'getDateTime',
        'readableRelativeDateTime' => 'getRelativeDateTime',
        'readableDuration' => 'getDuration',
        'readableDateTimeLength' => 'getDateTimeLength',

        // FILE SIZES
        'readableFileSize' => 'getFileSize',
    ];

    /**
     * Deprecated 1.x directive => Readable method. Removed in the first line that supports PHP 8.6.
     */
    private const DEPRECATED_DIRECTIVES = [
        'ReadableNumber' => 'getNumber',
        'ReadableHumanNumber' => 'getCompactNumber',
        'ReadableNumberToString' => 'getNumberInWords',
        'ReadableDecimal' => 'getDecimal',
        'ReadableDecInt' => 'getDecimalOrInteger',
        'ReadableDate' => 'getDate',
        'ReadableTime' => 'getTime',
        'ReadableDateTime' => 'getDateTime',
        'ReadableDiffDateTime' => 'getRelativeDateTime',
        'ReadableTimeLength' => 'getDuration',
        'ReadableDateTimeLength' => 'getDateTimeLength',
        'ReadableSize' => 'getFileSize',
    ];

    /**
     * Register every directive. Each one echoes the raw (unescaped) result, as in 1.x.
     */
    public function register(BladeCompiler $blade): void
    {
        foreach (self::DIRECTIVES + self::DEPRECATED_DIRECTIVES as $directive => $method) {
            $blade->directive($directive, function (?string $data) use ($method) {
                return '<?php echo '.Readable::class."::{$method}({$data}); ?>";
            });
        }
    }
}
