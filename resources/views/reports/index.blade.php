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
    <div class="panel">
      <h1>{{ $projectName }} <img src="{{ asset($currentProject->logoUrl) }}" alt="{{ $projectName }}" width="32px"></h1>

      <div class="form__group">
        <label>Bilans par mois</label>
        <ul class="label-list">
          @foreach($reports as $month => $nope)
            <li class="label"><a href="#{{ Str::slug($month)}}">{{ $month }}</a></li>
          @endforeach
        </ul>
      </div>

      <div class="form__group" style="margin-top: .5em">
        <label>Actions</label>
        <a class="button small secondary" href="#modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path style="fill:#fff;" d="M5 9c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3zm0-2c-2.762 0-5 2.239-5 5s2.238 5 5 5 5-2.239 5-5-2.238-5-5-5zm15 9c-1.165 0-2.204.506-2.935 1.301l-5.488-2.927c-.23.636-.549 1.229-.944 1.764l5.488 2.927c-.072.301-.121.611-.121.935 0 2.209 1.791 4 4 4s4-1.791 4-4-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0-22c-2.209 0-4 1.791-4 4 0 .324.049.634.121.935l-5.488 2.927c.395.536.713 1.128.944 1.764l5.488-2.927c.731.795 1.77 1.301 2.935 1.301 2.209 0 4-1.791 4-4s-1.791-4-4-4zm0 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2z"/></svg>
          <span style="margin-left: .5em">Partager</span>
        </a>
        <a class="button small secondary" href="{{ $downloadUrl }}">
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path style="fill:#fff;" d="M16 11h5l-9 10-9-10h5v-11h8v11zm1 11h-10v2h10v-2z"/></svg>
          <span style="margin-left: .3em">Exporter en CSV</span>
        </a>
      </div>
    </div>

    @foreach($reports as $month => $reports)
      <h5 id="{{ Str::slug($month)}}">{{ ucfirst($month) }}</h5>
      @foreach($reports as $report)
      <div class="panel">
        <div class="panel__header">
          <h3>{{ $report->week_number }}</h3>
          <small class="panel__header-extra">Du {{ $report->startOfWeek->isoFormat('LL') }} au {{ $report->endOfWeek->isoFormat('LL') }}</small>
        </div>
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
    @endforeach

  </div>
  <div class="modal__backdrop" id="modal">
    <div class="modal">
      <h2>Partager l'historique des bilans</h2>
      <p>Pour partager <b>uniquement</b> l'historique des bilans du projet {{ $projectName }}, vous pouvez partager ce lien unique.</p>
      <div class="form__group">
        <input type="text" readonly="readonly" value="{{ $shareUrl }}" id="js-copy-target">
        <button class="button small secondary" id="js-copy-btn">
          <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" style="margin-right: .3em"><path style="fill:#fff;" d="M13.508 11.504l.93-2.494 2.998 6.268-6.31 2.779.894-2.478s-8.271-4.205-7.924-11.58c2.716 5.939 9.412 7.505 9.412 7.505zm7.492-9.504v-2h-21v21h2v-19h19zm-14.633 2c.441.757.958 1.422 1.521 2h14.112v16h-16v-8.548c-.713-.752-1.4-1.615-2-2.576v13.124h20v-20h-17.633z"/></svg>
          Copier
        </button>
      </div>
      <div class="form__group button__group">
        <a class="button secondary" href="#modal-section">Fermer</a>
      </div>
    </div>
  </div>
</div>
@endsection
