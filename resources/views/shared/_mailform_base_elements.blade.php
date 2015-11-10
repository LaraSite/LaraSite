{!! BootForm::hidden('_mailform_subject')->value($_mailform_subject) !!}
{!! BootForm::text(trans('attributes.mailform.name'), 'name', old('name'))->required() !!}
{!! BootForm::email(trans('attributes.mailform.email'), 'email', old('email'))->required() !!}
{!! BootForm::email(trans('attributes.mailform._confirm_email'), '_confirm_email', old('_confirm_email'))->required() !!}
