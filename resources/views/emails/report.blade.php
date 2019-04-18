@component('mail::message')

# {{ __('form.retrospective_title', ['week' => $weekNumber]) }}
{{ __('emails.intro') }}

@if($helpRequests->count() > 0)
## {{ __('emails.help_requests') }}
@component('mail::panel')
@foreach($helpRequests as $project => $help)
- **{{ $project }} :** {{ $help }}
@endforeach
@endcomponent
@endif

## {{ __('emails.news') }}
@foreach ($reports as $report)
@component('mail::panel')
## <img src="{{ asset($report->projectObject()->logoUrl) }}" alt="{{ $report->project }}" width="20"> {{ $report->project }}

- **{{ __('emails.mood') }}** {{ $report->spirit }}
- **{{ __('emails.priority') }}** {{ $report->priorities }}
- **{{ __('emails.ups_and_downs') }}** {{ $report->victories }}
@if (isset($report->help))
- **{{ __('emails.help') }}** {{ $report->help }}
@endif
@endcomponent
@endforeach

@if ($projectsNoInfo->count() > 0)
{{ __('emails.no_news', ['projects' => $projectsNoInfo->implode(', ')]) }}
@else
{{ __('emails.all_filled') }}
@endif

{{ __('emails.outro') }}

@endcomponent
