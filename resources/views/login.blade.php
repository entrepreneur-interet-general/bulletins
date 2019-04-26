@extends('master')

@section('content')
<form action="{{ route('login') }}" method="post" name="form">
  @csrf
  <h1>{{ trans('login.title') }}</h1>

  <p>{{ trans('login.description') }}</p>

  @if (session()->has('error'))
  <div class="notification error">
    {{ session('error') }}
  </div>
  @endif

  @if ($passwordHint)
  <div class="form__group">
    <div class="text-quote"><p>{{ $passwordHint }}</p></div>
  </div>
  @endif

  <div class="form__group">
    <label for="help">{{ trans('login.password') }}</label>
    <input type="password" name="password" autofocus="true" required="true">
  </div>

  <div class="form__group">
    <button class="button" type="submit" name="validate">{{ trans('login.login') }}</button>
  </div>
</form>
@endsection
