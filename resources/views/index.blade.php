@extends('master')

@section('content')
@if ($canBeFilled and ! $allFilled)
  <form action="{{ route('reports.store') }}" method="post" name="form">
    @csrf
    <h1>Bilan de la semaine {{ $week }}</h1>
    <p>Faites le point sur la semaine qui vient de s'écouler. 5 minutes, 300 caractères par champ — un peu plus de 2 tweets.</p>

    <div class="form__group">
      <div class="text-quote"><p>Vos réponses seront partagées par e-mail à toute l'équipe <b>le vendredi à 15h.</b></p></div>
    </div>

    @if ($errors->any())
    <div class="notification error">
      @foreach ($errors->all() as $error)
      {{ $error }}<br>
      @endforeach
    </div>
    @endif

    <div class="form__group">
      <label for="project">Votre projet</label>
      <select name="project">
        @foreach($projects->map->name as $project)
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
        <legend>Votre état d'esprit</legend>
        <input type="radio" name="spirit" id="spirit" value="☹️"><label for="spirit" class="label-inline">☹️</label>
        <input type="radio" name="spirit" id="spirit" value="😐"><label for="spirit" class="label-inline">😐</label>
        <input type="radio" name="spirit" id="spirit" value="🙂"><label for="spirit" class="label-inline">🙂</label>
        <input type="radio" name="spirit" id="spirit" value="😀"><label for="spirit" class="label-inline">😀</label>
      </fieldset>
    </div>

    <div class="form__group">
      <label for="priorities">Votre priorité</label>
      <textarea name="priorities" rows="3" placeholder="Le sujet le plus important de votre semaine" required maxlength="300">{{ old('priorities') }}</textarea>
    </div>

    <div class="form__group">
      <label for="victories">Vos hauts et vos bas</label>
      <textarea name="victories" rows="3" placeholder="Ce qui a marché et ce qui vous a donné du fil à retordre" required maxlength="300">{{ old('victories') }}</textarea>
    </div>

    <div class="form__group">
      <label for="help">Demande d'aide<span class="label">Optionnel</span></label>
      <textarea name="help" rows="3" placeholder="Faites appel à la communauté pour surmonter un blocage" maxlength="300">{{ old('help') }}</textarea>
    </div>

    <div class="form__group">
      <button class="button" type="submit" name="validate">Enregistrer</button>
    </div>
  </form>
@else
  <h1>Semaine {{ $week }}</h1>
  <p>
    Il n'est plus possible de partager ses informations pour cette semaine. À la semaine prochaine !
  </p>
@endif
@endsection
