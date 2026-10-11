<?php

namespace Pharaonic\Laravel\Readable;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ReadableServiceProvider extends ServiceProvider
{
    /**
     * Blade directive => Readable method.
     */
    private const DIRECTIVES = [
        // NUMBERS
        'ReadableNumber' => 'getNumber',
        'ReadableHumanNumber' => 'getHumanNumber',
        'ReadableNumberToString' => 'getNumberToString',
        'ReadableDecimal' => 'getDecimal',
        'ReadableDecInt' => 'getDecInt',

        // DATE & TIME
        'ReadableDate' => 'getDate',
        'ReadableTime' => 'getTime',
        'ReadableDateTime' => 'getDateTime',
        'ReadableDiffDateTime' => 'getDiffDateTime',
        'ReadableTimeLength' => 'getTimeLength',
        'ReadableDateTimeLength' => 'getDateTimeLength',

        // FILE SIZES
        'ReadableSize' => 'getSize',
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach (self::DIRECTIVES as $directive => $method) {
            Blade::directive($directive, function (?string $data) use ($method) {
                return '<?php echo '.Readable::class."::{$method}({$data}); ?>";
            });
        }
    }
}
