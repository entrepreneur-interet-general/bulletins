@extends('master')

@section('section-class')
section-grey
@endsection

@section('content')
@php
  $currentProject = $reports->first()->project;
  $projectObject = $reports->first()->projectObject();
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
    <h1>Bilans du projet {{ $currentProject }} <img src="{{ asset($projectObject->logoUrl) }}" alt="{{ $currentProject }}" width="32px"></h1>

    <div class="text-right">
      <a class="button small secondary" href="#modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path style="fill:#fff;" d="M5 9c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3zm0-2c-2.762 0-5 2.239-5 5s2.238 5 5 5 5-2.239 5-5-2.238-5-5-5zm15 9c-1.165 0-2.204.506-2.935 1.301l-5.488-2.927c-.23.636-.549 1.229-.944 1.764l5.488 2.927c-.072.301-.121.611-.121.935 0 2.209 1.791 4 4 4s4-1.791 4-4-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-22c-2.209 0-4 1.791-4 4 0 .324.049.634.121.935l-5.488 2.927c.395.536.713 1.128.944 1.764l5.488-2.927c.731.795 1.77 1.301 2.935 1.301 2.209 0 4-1.791 4-4s-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg>
        <span style="margin-left: .5em">Partager</span>
      </a>
    </div>

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
  <div class="modal__backdrop" id="modal">
    <div class="modal">
      <h2>Partager l'historique des bilans</h2>
      <p>Pour partager <b>uniquement</b> l'historique des bilans du projet {{ $currentProject }}, vous pouvez partager ce lien unique.</p>
      <div class="form__group">
        <input type="text" disabled="true" value="{{ $shareUrl }}">
      </div>
      <div class="form__group button__group">
        <a class="button secondary" href="#modal-section">Fermer</a>
      </div>
    </div>
  </div>
</div>
@endsection
