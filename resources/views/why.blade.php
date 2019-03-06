@extends('master')

@section('content')
<div class="dark-background" style="max-width: 750px; margin: 0 auto">
  <h1>Pourquoi cet outil</h1>
  <p class="lead-text">Cet outil est une alternative asynchrone et écrite aux réunions de suivi hebdomadaires, aussi appelées « <i>stand-up meetings</i> »</p>

  <h2>Principe</h2>
  <p>
    Les <i>stand-up</i> sont des réunions durant lesquels plusieurs personnes se réunissent au même endroit, au même moment, pour dire à tour de rôle ce sur quoi elles travaillent. Ce sont des points d’étapes récurrents, qui servent à faire circuler des informations au sein d’une équipe. Problème : les <i>stand-up</i> demandent à plusieurs personnes d’interrompre leur travail respectif au même moment pour absorber des informations qui ne leur seront sans doute pas utiles au même moment.
  </p>

  <p>
    Au lieu d’interrompre le travail de tout le monde, ceci permet à chaque équipe de faire un bilan écrit de la semaine écoulée. Les bilans sont saisis dans un formulaire, que chaque équipe remplit quand bon lui semble — du moment qu’elle le remplit à temps. Une fois renseignés, les bilans sont ensuite agrégés dans un e-mail qui est envoyé à tout le monde, et que chacun peut lire quand bon lui semble. Les informations circulent ainsi sans nécessiter de réunion.
  </p>

  <h2>Fonctionnement</h2>
  <ol>
    <li>Chaque équipe entre le bilan de la semaine en complétant le formulaire de suivi, à raison d’un bilan par équipe ;</li>
    <li>Les bilans saisis sont agrégés dans un e-mail qui est envoyé automatiquement chaque vendredi à 15 heures.</li>
  </ol>

  <h2>Visibilité des réponses</h2>
  <p>
    Bien que le code de l’application soit ouvert, les réponses saisies dans le formulaire de l'application ne sont pas publiques. Toutefois, ces informations sont utiles pour chaque équipe : c'est pourquoi il est possible d'accéder à un historique de ses bilans, partager les bilans à l'aide d'un lien unique et d'exporter les données.
  </p>

  <h2>Échéances hebdomadaires</h2>
  <p>
    Les échéances à garder en tête, chaque semaine :
    <ul>
      <li>Le lundi matin : ouverture du formulaire pour la semaine en cours ;</li>
      <li>Le vendredi à 14h45 : fermeture du formulaire ;</li>
      <li>Le vendredi à 15h05 : envoi du récapitulatif.</li>
    </ul>
  </p>
</div>

@endsection
