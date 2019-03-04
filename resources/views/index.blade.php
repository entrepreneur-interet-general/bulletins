@extends('master')

@section('content')
<form action="/reports/store" method="post" name="form">
  @csrf
  <h1>Semaine {{ $week }}</h1>

  <div class="form__group">
    <div class="text-quote"><p>Ces informations seront partagées par e-mail à toute l'équipe <b>le vendredi à 15h.</b></p></div>
  </div>

  @if ($errors->any())
  <div class="notification error">
    @foreach ($errors->all() as $error)
    {{ $error }}<br>
    @endforeach
  </div>
  @endif

  <div class="form__group">
    <label for="project">Notre projet</label>
    <select name="project">
      @foreach($projects as $project)
      <option
        value="{{ $project }}"
        {{ (old("project") == $project ? "selected": "") }}
        {{ $filledProjects->contains($project) ? "disabled": ""}}
      >
        {{ $filledProjects->contains($project) ? "$project (déjà renseigné)" : $project }}
      </option>
      @endforeach
    </select>
  </div>

  <div class="form__group">
    <fieldset>
      <legend>Notre état d'esprit</legend>
      <input type="radio" name="spirit" id="spirit" value="☹️"><label for="spirit" class="label-inline">☹️</label>
      <input type="radio" name="spirit" id="spirit" value="😐"><label for="spirit" class="label-inline">😐</label>
      <input type="radio" name="spirit" id="spirit" value="😀"><label for="spirit" class="label-inline">😀</label>
    </fieldset>
  </div>

  <div class="form__group">
    <label for="priorities">Notre priorité</label>
    <textarea name="priorities" required maxlength="300">{{ old('priorities') }}</textarea>
  </div>

  <div class="form__group">
    <label for="victories">Notre victoire, difficulté</label>
    <textarea name="victories" required maxlength="300">{{ old('victories') }}</textarea>
  </div>

  <div class="form__group">
    <label for="help">Notre besoin<span class="label">Optionnel</span></label>
    <textarea name="help" maxlength="300">{{ old('help') }}</textarea>
  </div>

  <div class="form__group">
    <button class="button" type="submit" name="validate">Partager à l'équipe</button>
  </div>
</form>
@endsection
