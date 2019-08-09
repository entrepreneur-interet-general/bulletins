@extends('master')

@section('content')
@if ($canBeFilled and ! $allFilled)
  <form action="{{ route('reports.store') }}" method="post" name="form">
    @csrf
    <h1>{{ trans('form.retrospective_title', compact('week')) }}</h1>
    <p>{{ trans('form.description') }}</p>

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
      <label for="project">{{ trans('form.project') }}</label>
      <select name="project">
        <option disabled selected value>{{ trans('form.select_project') }}</option>
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
        <legend>{{ trans('form.team_mood') }}</legend>
        <input type="radio" name="spirit" id="spirit" value="☹️"><label for="spirit" class="label-inline">☹️</label>
        <input type="radio" name="spirit" id="spirit" value="😐"><label for="spirit" class="label-inline">😐</label>
        <input type="radio" name="spirit" id="spirit" value="🙂"><label for="spirit" class="label-inline">🙂</label>
        <input type="radio" name="spirit" id="spirit" value="😀"><label for="spirit" class="label-inline">😀</label>
      </fieldset>
    </div>

    <div class="form__group">
      <label for="priorities">{{ trans('form.priority') }}</label>
      <textarea name="priorities" rows="3" placeholder="{{ trans('form.priority.placeholder') }}" required maxlength="300">{{ old('priorities') }}</textarea>
    </div>

    <div class="form__group">
      <label for="victories">{{ trans('form.ups_and_downs') }}</label>
      <textarea name="victories" rows="3" placeholder="{{ trans('form.ups_and_downs.placeholder') }}" required maxlength="300">{{ old('victories') }}</textarea>
    </div>

    <div class="form__group">
      <label for="help">{{ trans('form.help') }}<span class="label">{{ trans('form.optional') }}</span></label>
      <textarea name="help" rows="3" placeholder="{{ trans('form.help.placeholder') }}" maxlength="300">{{ old('help') }}</textarea>
    </div>

    <div class="form__group">
      <label for="key_date">{{ trans('form.key_date') }}<span class="label">{{ trans('form.optional') }}</span></label>
      <input type="date" min="{{ now()->format('Y-m-d')}}" name="key_date" value="{{ old('key_date') }}" style="margin-bottom: 1em">
      <input type="text" name="key_date_description" placeholder="{{ trans('form.key_date.placeholder') }}" value="{{ old('key_date_description') }}">
    </div>

    <div class="form__group">
      <button class="button" type="submit" name="validate">{{ trans('form.save') }}</button>
    </div>
  </form>
@else
  <h1>{{ trans('form.retrospective_title', compact('week')) }}</h1>
  <p>
    {{ trans('form.cant_fill') }}
  </p>
@endif
@endsection
