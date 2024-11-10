<!DOCTYPE html>
<html>
<head>
    <title>Rappel de paiement de loyer</title>
</head>
<body>
    <p>Bonjour {{ $locataire->prenom }} {{ $locataire->nom }},</p>
    <p>Nous vous rappelons que la fin du mois est arrivée. Veuillez procéder au paiement de votre loyer de {{ $locataire->montant_loyer_ttc }}.</p>
    <p>Merci,</p>
    <p>Votre gestionnaire immobilier</p>
</body>
</html>