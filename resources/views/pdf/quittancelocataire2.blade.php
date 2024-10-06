<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border: 2px solid #000;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }
        .header .left {
            width: 140%;
        }
        .header .left p {
            margin: 2px 0;
            font-size: 14px;
        }
        .header .right {
            text-align: right;
            font-size: 14px;
        }
        .title {
            text-align: center;
            margin: 20px 0;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 1px dashed #000;
            padding: 10px;
        }
        .table {
            width: 100%;
            margin: 20px 0;
        }
        .table th, .table td {
            text-align: left;
            padding: 8px;
            font-size: 14px;
            border-bottom: 1px solid #000;
        }
        .table th {
            width: 25%;
        }
        .table td {
            width: 75%;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            text-align: center;
            color: #555;
        }
        .signature {
            margin-top: 30px;
            text-align: right;
            font-size: 14px;
            font-weight: bold;
        }
        .note {
            margin-top: 30px;
            font-size: 12px;
            text-align: left;
            color: #000;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<div class="container">
    <div style=" text-align: center; margin-bottom: 1px;">
        <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner" style="width: 500px; max-width: 100%; height: auto;">
    </div>
    <!-- En-tête avec les informations principales -->
    <div class="header">
        <div class="left">
            <p><strong>Compagnie Immobilière du Sénégal (C.I.S.)</strong></p>
            <p>Location - Gestion - Achat - Construction - Rénovation</p>
            <p><strong>Adresse :</strong> {{$user->structure->adresse_structure ? $user->structure->adresse_structure : ''}}</p>
            <p><strong>Téléphone :</strong> {{$user->structure->numero_tel1_structure ? $user->structure->numero_tel1_structure : ''}}</p>
        </div>
        <div class="right">
            <p><strong>Quittance N° :</strong> {{ $quittance->id }}</p>
            <p><strong>Montant :</strong> {{ number_format($montant_ttc, 0, ',', ' ') }} F CFA</p>
        </div>
    </div>

    <!-- Titre quittance -->
    <div class="title">
        Quittance de Loyer
    </div>

    <!-- Informations du paiement -->
    <table class="table">
        <tr>
            <th>Reçu de</th>
            <td>{{$locataire->prenom}} {{$locataire->nom}}</td>
        </tr>
        <tr>
            <th>Pour le montant de</th>
            <td>{{ number_format($montant_ttc, 0, ',', ' ') }} F CFA</td>
        </tr>
        <tr>
            <th>Maison située à</th>
            <td>{{$locataire->adresse_profession}}</td>
        </tr>
        <tr>
            <th>Période</th>
            <td>
                {{ \Carbon\Carbon::parse($quittance->dernier_date_paiement)->startOfMonth()->format('d/m/Y') }} 
                au 
                {{ \Carbon\Carbon::parse($quittance->dernier_date_paiement)->endOfMonth()->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <th>Date de paiement</th>
            <td>{{ \Carbon\Carbon::parse($quittance->dernier_date_paiement)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <!-- Signature -->
    <div class="signature">
        Signé : A. T.
    </div>

    <!-- Note légale -->
    <div class="note">
        <p><strong>Nota :</strong> Un locataire ne peut déménager sans justifier avoir réglé son loyer. Le paiement doit être fait avant toute occupation prolongée du bien.</p>
    </div>
</div>

</body>
</html>