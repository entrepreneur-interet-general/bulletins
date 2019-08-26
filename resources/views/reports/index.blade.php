@extends('master')

@section('section-class')
section-grey
@endsection

@section('content')
@php
  $projectName = $currentProject->name;
@endphp

<div class="dashboard">
  <aside class="side-menu" role="navigation">
    <ul>
      @foreach($projects as $project)
        <li>
          <a
            href="{{ route('reports.index', $project) }}"
            class="{{ $projectName === $project ? 'active' : '' }}"
            >{{ $project }}</a></li>
      @endforeach
    </ul>
  </aside>
  <div class="main">
    @include('reports._info')

    @foreach($reports as $month => $reports)
      <h5 id="{{ Str::slug($month)}}">{{ ucfirst($month) }}</h5>
      @foreach($reports as $report)
      <div class="panel">
        <div class="panel__header">
          <h3 id="{{ $report->week_number }}">
            <a href="#{{ $report->week_number }}" aria-hidden="true" class="header-anchor">#</a>
            {{ $report->week_number }}
          </h3>
          <small class="panel__header-extra">
          {{ trans('reports.time_period', ['start' => $report->startOfWeek->isoFormat('LL'), 'end' => $report->endOfWeek->isoFormat('LL')]) }}
          </small>
        </div>
        <ul>
          <li><b>{{ trans('reports.mood') }}</b> {{ $report->spirit }}</li>
          <li><b>{{ trans('reports.priority') }}</b> {!! nl2br(e($report->priorities)) !!}</li>
          <li><b>{{ trans('reports.ups_and_downs') }}</b> {!! nl2br(e($report->victories)) !!}</li>
          @if ($report->help)
            <li><b>{{ trans('reports.help') }}</b> {!! nl2br(e($report->help)) !!}</li>
          @endif
        </ul>
      </div>
      @endforeach
    @endforeach

  </div>
  <div class="modal__backdrop" id="modal">
    <div class="modal">
      <h2>{{ trans('reports.share_title') }}</h2>
      @lang('reports.share_description', ['project' => $projectName])
      <div class="form__group">
        <input type="text" readonly="readonly" value="{{ $shareUrl }}" id="js-copy-target">
        <button class="button small secondary" id="js-copy-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" style="margin-right: .3em"><path style="fill:#fff;" d="M13.508 11.504l.93-2.494 2.998 6.268-6.31 2.779.894-2.478s-8.271-4.205-7.924-11.58c2.716 5.939 9.412 7.505 9.412 7.505zm7.492-9.504v-2h-21v21h2v-19h19zm-14.633 2c.441.757.958 1.422 1.521 2h14.112v16h-16v-8.548c-.713-.752-1.4-1.615-2-2.576v13.124h20v-20h-17.633z"/></svg>
          {{ trans('reports.copy') }}
        </button>
      </div>
      <div class="form__group button__group">
        <a class="button secondary" href="#modal-section">{{ trans('reports.close') }}
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
