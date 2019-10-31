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
        @foreach($data as $month => $dates)
          <h3>{{ $month }}</h3>
          <ul>
            @foreach($dates as $date)
              <li>{{ $date->date->isoFormat('LL') }} – {{ $date->description }}</li>
            @endforeach
          </ul>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
