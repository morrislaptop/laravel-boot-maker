<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class FilesystemTest extends PartialTestCase
{
    use Filesystem;

    public function test_it_can_test_filesystem()
    {
        Storage::disk('local')->put('example.txt', 'Contents');

        $this->assertEquals('Contents', Storage::disk('local')->get('example.txt'));
    }
}
