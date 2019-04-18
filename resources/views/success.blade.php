@extends('master')

@section('content')
<h1>{{ __('form.retrospective_title', compact('week')) }}</h1>
<div class="notification success">{{ __('success.saved') }}</div>

<p>{{ __('success.thanks') }}</p>

<iframe src="https://giphy.com/embed/{{ $gif->id }}" width="{{ $gif->width }}" height="{{ $gif->height }}" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></p>
@endsection
