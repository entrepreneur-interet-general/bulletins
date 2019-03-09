@extends('master')

@section('content')
<form action="{{ route('login') }}" method="post" name="form">
  @csrf
  <h1>Accès à l'historique des bilans</h1>

    <p>Vous devez vous authentifier préalablement.</p>

    @if (session()->has('error'))
    <div class="notification error">
      {{ session('error') }}
    </div>
    @endif

  <div class="form__group">
    <label for="help">Mot de passe</label>
    <input type="password" required name="password">
  </div>

  <div class="form__group">
    <button class="button" type="submit" name="validate">S'authentifier</button>
  </div>
</form>
@endsection
