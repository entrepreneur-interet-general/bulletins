@extends('master')

@section('section-class')
section-grey
@endsection

@section('content')
@php
  $currentProject = $reports->first()->project;
@endphp

<div class="dashboard">
  <aside class="side-menu" role="navigation">
    <ul>
      @foreach($projects as $project)
        <li>
          <a
            href="{{ route('reports.index', $project) }}"
            class="{{ $currentProject === $project ? 'active' : '' }}"
            >{{ $project }}</a></li>
      @endforeach
    </ul>
  </aside>
  <div class="main">
    <h1>Bilans du projet {{ $currentProject }}</h1>
    @foreach($reports as $report)
    <div class="panel">
      <h3>{{ $report->week_number }}</h3>
      <ul>
        <li><b>État d'esprit :</b> {{ $report->spirit }}</li>
        <li><b>Priorité :</b> {{ $report->priorities }}</li>
        <li><b>Hauts et bas :</b> {{ $report->victories }}</li>
        @if ($report->help)
        <li><b>Demande d'aide :</b> {{ $report->help }}</li>
        @endif
      </ul>
    </div>
    @endforeach
  </div>
</div>
@endsection
