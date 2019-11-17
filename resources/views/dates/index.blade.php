@extends('master')

@section('section-class')
section-grey
@endsection

@section('content')
<div class="dashboard">
  <div class="main">
    <div class="panel">
      <div class="panel__header">
        <h2>{{ trans('dates.title') }}</h2>
      </div>
      <div class="form__group">
        @foreach($data as $month => $dates)
          <h3>{{ $month }}</h3>

          <div class="grid date_grid mb3">
            @foreach($dates as $date)
              <div class="card date_card">
                <div class="card__content">
                  <h3><img src="{{ asset($date->projectObject()->logoUrl) }}" alt="{{ $date->project }}" width="32px"> {{ $date->project }}</h3>
                  <div class="card__meta">{{ $date->date->isoFormat('LL') }}</div>
                  <p>{{ $date->description }}</p>
                </div>
              </div>
            @endforeach
          </div>

        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
