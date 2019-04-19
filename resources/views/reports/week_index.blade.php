@extends('master')

@section('section-class')
section-grey
@endsection

@section('content')
<div class="dashboard">
  <div class="main">
    <div class="panel">
      <div class="panel__header">
        <h2>{{ trans('reports.previous_reports') }}</h2>
      </div>
      <div class="form__group">
        @foreach($data as $month => $reports)
          <label>{{ $month }}</label>
          <ul class="label-list">
            @foreach($reports->pluck('week_number') as $week)
              <li class="label">
                <a href="{{ route('email_report', $week) }}">{{ $week }}</a>
              </li>
            @endforeach
          </ul>
        @endforeach

      </div>
    </div>
  </div>
</div>
@endsection
