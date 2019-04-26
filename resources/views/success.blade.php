@extends('master')

@section('content')
<h1>{{ trans('form.retrospective_title', compact('week')) }}</h1>
<div class="notification success">{{ trans('success.saved') }}</div>

<p>{{ trans('success.thanks') }}</p>

<iframe src="https://giphy.com/embed/{{ $gif->id }}" width="{{ $gif->width }}" height="{{ $gif->height }}" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></p>
@endsection
