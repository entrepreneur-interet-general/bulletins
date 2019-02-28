@extends('master')

@section('content')
<section class="section section-grey">
  <div class="container">
    <form action="/reports/store" method="post" name="form">
      @csrf

      <h1>Cette semaine</h1>

      @if ($projects->count() > 0)
        <p>
          Dites-nous ce que vous avez fait cette semaine {{ $week }}.
        </p>

        @if ($errors->any())
        <div class="notification error">
          @foreach ($errors->all() as $error)
            {{ $error }}<br>
          @endforeach
        </div>
        @endif

        <div class="form__group">
          <label for="project">Mon projet</label>
          <select name="project">
            @foreach($projects as $project)
            <option value="{{ $project }}" {{ (old("project") == $project ? "selected": "") }}>{{ $project }}</option>
            @endforeach
          </select>
        </div>

        <div class="form__group">
          <label for="priorities">Notre priorité de la semaine :</label>
          <textarea name="priorities" required maxlength="300">{{ old('priorities') }}</textarea>
        </div>

        <div class="form__group">
          <label for="victories">Des victoires ou des problèmes à partager ?</label>
          <textarea name="victories" required maxlength="300">{{ old('victories') }}</textarea>
        </div>

        <div class="form__group">
          <label for="help">Un besoin d'aide ?</label>
          <textarea name="help" maxlength="300">{{ old('help') }}</textarea>
        </div>

        <div class="form__group">
          <button class="button" type="submit" name="validate">Valider</button>
        </div>
      </form>

    @else
      <div class="notification success">Tout le monde a rempli ses informations !</div>
    @endif
  </div>
</section>
@endsection
