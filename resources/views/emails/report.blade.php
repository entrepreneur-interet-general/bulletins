@component('mail::message')

# Semaine {{ $weekNumber }}
Cette semaine, dans l'équipe.

@foreach ($reports as $report)
@component('mail::panel')
## {{ $report->project }}

- **État d'esprit :** {{ $report->spirit }}
- **Priorité :** {{ $report->priorities }}
- **Victoire / Difficulté :** {{ $report->victories }}
@if (isset($report->help))
- **Besoin : ** {{ $report->help }}
@endif
@endcomponent
@endforeach

@if ($projectsNoInfo)
Malheureusement, nous n'avons pas de nouvelles pour ces projets : {{ $projectsNoInfo->implode(', ') }} 😢.
@endif

Passez un bon week-end ! 🏝

@endcomponent
