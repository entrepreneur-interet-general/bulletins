@component('mail::message')

# Semaine {{ $weekNumber }}
Cette semaine, dans l'équipe.

@if($helpRequests->count() > 0)
## Demandes d'aide
@component('mail::panel')
@foreach($helpRequests as $project => $help)
- **{{ $project }} :** {{ $help }}
@endforeach
@endcomponent
@endif

## Nouvelles de la semaine
@foreach ($reports as $report)
@component('mail::panel')
## <img src="{{ asset($report->projectObject()->logoUrl) }}" alt="{{ $report->project }}" width="20"> {{ $report->project }}

- **État d'esprit :** {{ $report->spirit }}
- **Priorité :** {{ $report->priorities }}
- **Victoire / Difficulté :** {{ $report->victories }}
@if (isset($report->help))
- **Besoin :** {{ $report->help }}
@endif
@endcomponent
@endforeach

@if ($projectsNoInfo->count() > 0)
Malheureusement, nous n'avons pas de nouvelles pour ces projets : {{ $projectsNoInfo->implode(', ') }} 😢.
@else
Tout le monde a rempli son bilan ! Merci 💪
@endif

Passez un bon week-end ! 🏝

@endcomponent
