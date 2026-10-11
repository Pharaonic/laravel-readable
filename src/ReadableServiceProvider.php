<?php

namespace Pharaonic\Laravel\Readable;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class ReadableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->callAfterResolving('blade.compiler', function (BladeCompiler $blade) {
            (new BladeDirectives)->register($blade);
        });
    }
}
