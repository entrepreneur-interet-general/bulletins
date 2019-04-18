@extends('master')

@section('content')
@if ($canBeFilled and ! $allFilled)
  <form action="{{ route('reports.store') }}" method="post" name="form">
    @csrf
    <h1>{{ __('form.retrospective_title', compact('week')) }}</h1>
    <p>{{ __('form.description') }}</p>

    <div class="form__group">
      <div class="text-quote"><p>@lang('form.previous_bulletins.week')</p></div>
    </div>

    @if ($errors->any())
    <div class="notification error">
      @foreach ($errors->all() as $error)
      {{ $error }}<br>
      @endforeach
    </div>
    @endif

    <div class="form__group">
      <label for="project">{{ __('form.project') }}</label>
      <select name="project">
        @foreach($projects->map->name as $project)
        <option
          value="{{ $project }}"
          {{ (old("project") == $project ? "selected": "") }}
          {{ $filledProjects->contains($project) ? "disabled": ""}}
        >
          {{ $filledProjects->contains($project) ? "$project ".trans('form.already_filled') : $project }}
        </option>
        @endforeach
      </select>
    </div>

    <div class="form__group">
      <fieldset>
        <legend>{{ __('form.team_mood') }}</legend>
        <input type="radio" name="spirit" id="spirit" value="☹️"><label for="spirit" class="label-inline">☹️</label>
        <input type="radio" name="spirit" id="spirit" value="😐"><label for="spirit" class="label-inline">😐</label>
        <input type="radio" name="spirit" id="spirit" value="🙂"><label for="spirit" class="label-inline">🙂</label>
        <input type="radio" name="spirit" id="spirit" value="😀"><label for="spirit" class="label-inline">😀</label>
      </fieldset>
    </div>

    <div class="form__group">
      <label for="priorities">{{ __('form.priority') }}</label>
      <textarea name="priorities" rows="3" placeholder="{{ __('form.priority.placeholder') }}" required maxlength="300">{{ old('priorities') }}</textarea>
    </div>

    <div class="form__group">
      <label for="victories">{{ __('form.ups_and_downs') }}</label>
      <textarea name="victories" rows="3" placeholder="{{ __('form.ups_and_downs.placeholder') }}" required maxlength="300">{{ old('victories') }}</textarea>
    </div>

    <div class="form__group">
      <label for="help">{{ __('form.help') }}<span class="label">{{ __('form.optional') }}</span></label>
      <textarea name="help" rows="3" placeholder="{{ __('form.help.placeholder') }}" maxlength="300">{{ old('help') }}</textarea>
    </div>

    <div class="form__group">
      <button class="button" type="submit" name="validate">{{ __('form.save') }}</button>
    </div>
  </form>
@else
  <h1>{{ __('form.retrospective_title', compact('week')) }}</h1>
  <p>
    {{ __('form.cant_fill') }}
  </p>
@endif
@endsection
