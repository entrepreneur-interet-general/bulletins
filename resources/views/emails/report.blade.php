@component('mail::message')

# Semaine {{ $weekNumber }}
Cette semaine, dans le programme EIG.

@foreach ($reports as $report)
@component('mail::panel')
## Projet {{ $report->project }}

- **Nos priorités :** {{ $report->priorities }}
- **Nos victoires / problèmes :** {{ $report->victories }}
@if (isset($report->help))
- **Besoin d'aide !** {{ $report->help }}
@endif
@endcomponent
@endforeach

@if ($projectsNoInfo)
Malheureusement, nous n'avons pas de nouvelles pour ces projets : {{ $projectsNoInfo->implode(', ') }} 😢.
@endif

Passez un bon week-end ! 🏝

@endcomponent
