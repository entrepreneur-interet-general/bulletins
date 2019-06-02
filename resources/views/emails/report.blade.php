@component('mail::message')

# {{ trans('form.retrospective_title', ['week' => $weekNumber]) }}
{{ trans('emails.intro') }}

@if($helpRequests->count() > 0)
## {{ trans('emails.help_requests') }}
@component('mail::panel')
@foreach($helpRequests as $project => $help)
- **{{ $project }} :** {{ $help }}
@endforeach
@endcomponent
@endif

@if(! $upcomingDates->isEmpty())
## {{ trans('emails.upcoming_key_dates') }}
@component('mail::panel')
@foreach($upcomingDates as $upcomingDate)
- {{ trans('emails.key_date', ['date' => $upcomingDate->date->isoFormat('LL'), 'project' => $upcomingDate->project, 'description' => $upcomingDate->description])}}
@endforeach
@endcomponent
@endif

## {{ trans('emails.news') }}
@foreach ($reports as $report)
@component('mail::panel')
## <img src="{{ asset($report->projectObject()->logoUrl) }}" alt="{{ $report->project }}" width="20"> {{ $report->project }}

- **{{ trans('emails.mood') }}** {{ $report->spirit }}
- **{{ trans('emails.priority') }}** {{ $report->priorities }}
- **{{ trans('emails.ups_and_downs') }}** {{ $report->victories }}
@if (isset($report->help))
- **{{ trans('emails.help') }}** {{ $report->help }}
@endif
@endcomponent
@endforeach

@if ($projectsNoInfo->count() > 0)
{{ trans('emails.no_news', ['projects' => $projectsNoInfo->implode(', ')]) }}
@else
{{ trans('emails.all_filled') }}
@endif

{{ trans('emails.outro') }}

@endcomponent
