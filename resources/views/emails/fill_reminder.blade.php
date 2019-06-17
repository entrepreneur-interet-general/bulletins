@component('mail::message')

{{ trans('notifications.individual_reminder_mail', ['project' => $project]) }}

@component('mail::button', ['url' => $url])
{{ trans('notifications.individual_reminder_mail.button') }}
@endcomponent

@endcomponent
