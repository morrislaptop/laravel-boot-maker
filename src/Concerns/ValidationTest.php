<?php

namespace Morrislaptop\LaravelBootMaker\Concerns;

use Illuminate\Support\Facades\Validator;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class ValidationTest extends PartialTestCase
{
    use Validation;

    public function test_it_can_test_validation()
    {
        $validator = Validator::make(['title' => 'Hello world.'], [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertEquals(['body' => ['validation.required']], $validator->errors()->toArray());
    }
}
