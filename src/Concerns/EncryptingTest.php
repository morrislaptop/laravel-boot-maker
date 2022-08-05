<?php
namespace Morrislaptop\LaravelBootMaker\Concerns;

use App\Events\QuestionCreated;
use App\Listeners\AskQuestion;
use Illuminate\Support\Facades\Cache as CacheFacade;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Morrislaptop\LaravelBootMaker\Concerns\Events;
use Morrislaptop\LaravelBootMaker\Tests\PartialTestCase;

class EncryptingTest extends PartialTestCase
{
    use Encrypting;

    public function test_it_can_test_encrypting()
    {
        $encrypted = Crypt::encryptString('42');

        $this->assertEquals('42', Crypt::decryptString($encrypted));
    }
}
