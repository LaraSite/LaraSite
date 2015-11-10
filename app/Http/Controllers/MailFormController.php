<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Jobs\SendMailForm;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationException;

class MailFormController extends Controller
{
    public function sendmail(Request $request)
    {
        try {
            $this->dispatch(new SendMailForm($request->all()));
        } catch (ValidationException $e) {
            $this->throwValidationException(
                $request, $e->getMessageProvider()
            );
        }

        \Flash::success(trans('message.mailform_sent'));

        return back()->withInput();
    }
}
