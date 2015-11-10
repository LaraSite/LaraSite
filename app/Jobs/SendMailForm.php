<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Validation\ValidationException;

class SendMailForm extends Job implements SelfHandling
{
    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $validator = $this->validator();
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->sendMail();
    }

    /**
     * @return \Illuminate\Validation\Validator
     */
    protected function validator()
    {
        $validator = \Validator::make($this->inputs, [
            '_mailform_subject' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            '_confirm_email' => 'required|email|same:email',
        ]);
        $validator->setAttributeNames(trans('attributes.mailform'));

        return $validator;
    }

    protected function sendMail()
    {
        $to = \Config::get('mailform.delivery_to');
        $subject = $this->inputs['_mailform_subject'];
        $data = [];
        foreach($this->inputs as $key => $value) {
            if ($key[0] != '_') {
                $data[$key] = $value;
            }
        }

        \Mail::send(['text' => 'emails.mailform'], compact('data'), function($message) use ($data, $subject, $to) {
            $message
                ->from($data['email'], $data['name'])
                ->replyTo($data['email'], $data['name'])
                ->to($to['address'], $to['name'])
                ->subject($subject);
        });
    }
}
