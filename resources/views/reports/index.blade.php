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
      <h2>{{ $report->week_number }}</h2>
      <ul>
        <li>État d'esprit : {{ $report->spirit }}</li>
        <li>Priorité : {{ $report->priorities }}</li>
        <li>Hauts et bas : {{ $report->victories }}</li>
        @if ($report->help)
        <li>Demande d'aide : {{ $report->help }}</li>
        @endif
      </ul>
    </div>
    @endforeach
  </div>
</div>
@endsection
