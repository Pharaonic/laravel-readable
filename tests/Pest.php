<?php

use Pharaonic\Laravel\Readable\Tests\TestCase;

uses(TestCase::class)->in('Compatibility', 'Feature', 'Unit');

/**
 * Render a Blade template string through the view factory.
 */
function renderBlade(string $template, array $data = []): string
{
    $path = tempnam(sys_get_temp_dir(), 'readable').'.blade.php';
    file_put_contents($path, $template);

    try {
        return view()->file($path, $data)->render();
    } finally {
        unlink($path);
    }
}
