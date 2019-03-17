@extends('master')

@section('content')
<h1>Bilan de la semaine {{ $week }}</h1>
<div class="notification success">Tout est bien enregistré !</div>

<p>Merci d'avoir pris quelques minutes pour nous dire ce qu'il s'est passé cette semaine ! Passe une bonne journée.</p>

<iframe src="https://giphy.com/embed/{{ $gif->id }}" width="{{ $gif->width }}" height="{{ $gif->height }}" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></p>
@endsection
