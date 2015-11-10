<?php

namespace Test\Unit\Http\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Jobs\SendMailForm;
use Mockery as m;

class MailFormControllerTest extends \TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        \Mail::pretend(true);
    }

    public function testSendmail()
    {
        $this->expectsJobs(SendMailForm::class);

        $this->post('mailform', []);

        $this->assertTrue($this->response->isRedirect());
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }

    public function testSendmailWithInvalidData()
    {
        $this->post('mailform', []);

        $this->assertTrue($this->response->isRedirect());
        $this->assertSessionHasErrors();
//        $this->dumpErrorMessages();
    }
}
