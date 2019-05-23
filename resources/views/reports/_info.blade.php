<div class="panel">
  <h1>{{ $projectName }} <img src="{{ asset($currentProject->logoUrl) }}" alt="{{ $projectName }}" width="32px"></h1>

  @if($reports->count() > 1)
    <div class="form__group">
      <label>{{ trans('reports.by_month') }}</label>
      <ul class="label-list">
        @foreach($reports as $month => $nope)
          <li class="label"><a href="#{{ Str::slug($month)}}">{{ $month }}</a></li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($pastDates->count() > 1)
    <div class="form__group">
      <label>{{ trans('reports.past_dates') }}</label>
      <ul>
        @foreach($pastDates as $pastDate)
          <li class="text-grey-dark">{{ $pastDate->date->isoFormat('LL') }} – {{ $pastDate->description }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($upcomingDates->count() > 1)
    <div class="form__group">
      <label>{{ trans('reports.upcoming_dates') }}</label>
      <ul>
        @foreach($upcomingDates as $upcomingDate)
          <li>{{ $upcomingDate->date->isoFormat('LL') }} – {{ $upcomingDate->description }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form__group mt-1">
    <label>{{ trans('reports.actions') }}</label>
    <a class="button small secondary" href="#modal">
      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path style="fill:#fff;" d="M5 9c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3zm0-2c-2.762 0-5 2.239-5 5s2.238 5 5 5 5-2.239 5-5-2.238-5-5-5zm15 9c-1.165 0-2.204.506-2.935 1.301l-5.488-2.927c-.23.636-.549 1.229-.944 1.764l5.488 2.927c-.072.301-.121.611-.121.935 0 2.209 1.791 4 4 4s4-1.791 4-4-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-22c-2.209 0-4 1.791-4 4 0 .324.049.634.121.935l-5.488 2.927c.395.536.713 1.128.944 1.764l5.488-2.927c.731.795 1.77 1.301 2.935 1.301 2.209 0 4-1.791 4-4s-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg>
      <span style="margin-left: .5em">{{ trans('reports.share') }}</span>
    </a>
    <a class="button small secondary" href="{{ $downloadUrl }}">
      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path style="fill:#fff;" d="M16 11h5l-9 10-9-10h5v-11h8v11zm1 11h-10v2h10v-2z"/></svg>
      <span style="margin-left: .3em">
        {{ trans('reports.csv_export') }}
      </span>
    </a>
  </div>
</div>
