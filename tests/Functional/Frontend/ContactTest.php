<?php

namespace Test\Functional\Frontend;

use App\Jobs\SendMailForm;

class ContactTest extends \TestCase
{
    public function testSendMail()
    {
        $this->expectsJobs(SendMailForm::class);

        $this->visit('contact')
            ->type('Someone', 'name')
            ->type('someone@customer.com', 'email')
            ->type('someone@customer.com', '_confirm_email')
            ->type('Subject', 'subject')
            ->type('FooBar', 'body')
            ->press('Submit')

            ->seePageIs('contact')
            ->see('Sent successfully.');
    }

    public function testValidationFail()
    {
        $this->visit('contact')
            ->press('Submit')

            ->seePageIs('contact')
            ->see('The Name field is required.')
            ->see('The Email field is required.')
            ->see('The Confirm Email field is required.');
    }
}
