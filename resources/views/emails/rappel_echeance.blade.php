<!DOCTYPE html>
<html>
<head>
    <title>Rappel de renouvellement de contrat</title>
</head>
<body>

@php
    use \Carbon\Carbon;
@endphp

<p>Nous vous informons que la date de fin de votre contrat de location est prévue dans un mois, le {{ Carbon::parse($locataire->date_echeance_contrat)->format('d/m/Y') }}.</p>
<p>Nous vous invitons à nous contacter si vous souhaitez renouveler votre contrat ou pour toute autre question relative à votre location.</p>

Cordialement,
<p>L'équipe de gestion immobilière</p>
</body>
</html>