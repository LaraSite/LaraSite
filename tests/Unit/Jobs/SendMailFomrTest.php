<?php

namespace Test\Unit\Jobs;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Mail\Message;
use App\Jobs\SendMailForm;
use Mockery as m;

class SendMailFormTest extends \TestCase
{
    use DatabaseTransactions;

    protected $to;

    public function setUp()
    {
        parent::setUp();

        \Mail::pretend(true);
        $this->to = [
            'address' => 'foo@bar.com',
            'name' => 'foobar'
        ];
        \Config::set('mailform.delivery_to', $this->to);
    }

    public function testSendMail()
    {
        $datas = $this->validData([
            'title' => 'TITLE',
            'question' => 'QUESTION'
        ]);
        $filterd_datas = [];
        foreach ($datas as $key => $value) {
            if ($key[0] != '_') {
                $filterd_datas[$key] = $value;
            }
        }

        $message = m::mock(Message::class);
        $message->shouldReceive('from')->once()
            ->with($datas['email'], $datas['name'])
            ->andReturn($message);
        $message->shouldReceive('replyTo')->once()
            ->with($datas['email'], $datas['name'])
            ->andReturn($message);
        $message->shouldReceive('to')->once()
            ->with($this->to['address'], $this->to['name'])
            ->andReturn($message);
        $message->shouldReceive('subject')->once()
            ->with($datas['_mailform_subject'])
            ->andReturn($message);

        \Mail::shouldReceive('send')->once()->with(
            ['text' => 'emails.mailform'],
            ['data' => $filterd_datas],
            m::on(function(\Closure $closure) use ($message) {
                $closure($message);

                return true;
            })
        );

        $mailForm = new SendMailForm($datas);
        $mailForm->handle();
    }

    public function testValidatorWithoutMailformSubject()
    {
        $this->handleWithInvalidInput(['_mailform_subject' => '']);
    }

    public function testValidatorWithoutName()
    {
        $this->handleWithInvalidInput(['name' => '']);
    }

    public function testValidatorWithoutEmail()
    {
        $this->handleWithInvalidInput(['email' => '']);
    }

    public function testValidatorWithoutConfirmEmail()
    {
        $this->handleWithInvalidInput(['_confirm_email' => '']);
    }

    public function testValidatorWithInvalidEmail()
    {
        $this->handleWithInvalidInput([
            'email' => 'INVALID_EMAIL',
            '_confirm_email' => 'INVALID_EMAIL'
        ]);
    }

    public function testValidatorIfDifferentEmails()
    {
        $datas = $this->validData([
            'email' => 'foo@domain.com',
            '_confirm_email' => 'var@domain.com'
        ]);

        try {
            $mailForm = new SendMailForm($datas);
            $mailForm->handle();

            $this->fail('Does not throw Exception!');
        } catch (ValidationException $e) {
            $this->assertTrue($e->getMessageProvider()->getMessageBag()->has('_confirm_email'));
//            var_dump($e->getMessageProvider()->getMessageBag()->get('_confirm_email'));
        }
    }

    protected function handleWithInvalidInput(array $inputs)
    {
        $datas = $this->validData($inputs);

        try {
            $mailForm = new SendMailForm($datas);
            $mailForm->handle();

            $this->fail('Does not throw Exception!');
        } catch (ValidationException $e) {
            foreach ($inputs as $key => $value) {
                $this->assertTrue($e->getMessageProvider()->getMessageBag()->has($key));
//                var_dump($e->getMessageProvider()->getMessageBag()->get($key));
            }
        }
    }

    protected function validData(array $datas = [])
    {
        $default = [
            '_mailform_subject' => 'SUBJECT',
            'name' => 'WHO',
            'email' => 'someone@domain.com',
            '_confirm_email' => 'someone@domain.com',
        ];

        return array_merge($default, $datas);
    }
}
