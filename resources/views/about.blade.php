@extends('master')

@section('content')
<div class="dark-background" style="max-width: 750px; margin: 0 auto">
  <h1>{{ trans('about.title') }}</h1>
  @lang('about.subtitle')

  @foreach (['feature', 'works', 'sharing', 'deadline'] as $section)
    <h2>@lang("about.{$section}_title")</h2>
    @lang("about.{$section}_description")
  @endforeach
</div>

@endsection
