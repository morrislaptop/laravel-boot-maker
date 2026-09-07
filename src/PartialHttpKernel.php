<?php

namespace Morrislaptop\LaravelBootMaker;

use Illuminate\Foundation\Http\Kernel;

/** Routes a request, assuming the concerns already registered what it needs. */
class PartialHttpKernel extends Kernel
{
    protected $bootstrappers = [];

    protected $middleware = [];
}
