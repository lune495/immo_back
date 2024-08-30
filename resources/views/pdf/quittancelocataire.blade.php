<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }
        .header .left,
        .header .right {
            width: 45%;
        }
        .header p {
            margin: 0;
            line-height: 1.5;
        }
        .company-initials {
            font-weight: bold;
            font-size: 24px;
            text-align: center;
            margin: 20px 0;
            color: #4CAF50;
        }
        .title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #555;
            margin: 20px 0;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: #fff;
        }
        td {
            color: #333;
        }
        .total {
            font-weight: bold;
            background-color: #f1f1f1;
        }
        .amount {
            font-weight: bold;
            text-align: right;
            color: #4CAF50;
            margin-top: 20px;
            font-size: 18px;
        }
        .signature {
            margin-top: 40px;
            text-align: center;
            font-size: 16px;
            color: #555;
            font-style: italic;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>

    <!-- En-tête avec informations du locataire et de l'agence -->
    <div class="header">
        <div class="left">
            <p><strong>Locataire :</strong> {{$locataire->nom}} {{$locataire->prenom}}</p>
            <p><strong>Adresse :</strong> {{$locataire->adresse_profession}}</p>
            <p><strong>Téléphone :</strong> {{$locataire->telephone}}</p>
        </div>
        <div class="right">
            <p><strong>Agence :</strong> {{$agence->nom_agence}}</p>
            <p><strong>Adresse :</strong> {{$agence->adresse}}</p>
            <p><strong>Date :</strong> {{ $quittance->dernier_date_paiement }}</p>
        </div>
    </div>

    <!-- Initiales de l'entreprise -->
    <div class="company-initials">
        AZIS (A2 IMMOBILIER ET SERVICES)
    </div>

    <div class="title">Quittance de Loyer N°{{ $quittance->id }}/{{ date('Y') }}</div>

    <table>
        <tr>
            <th>Désignation</th>
            <th>Loyer H.C</th>
            <th>TOM {{ $tom }}%</th>
            <th>CH.COMM {{ $cc }}%</th>
            <th>TVA {{ $tva }}%</th>
            <th>Total Loyer</th>
        </tr>
        <tr>
            <td>Date : {{ $quittance->dernier_date_paiement }}</td>
            <td>{{ number_format($locataire->montant_loyer_ht, 0, ',', ' ') }}</td>
            <td>{{ number_format($locataire->montant_loyer_ht * ($tom/100), 0, ',', ' ') }}</td>
            <td>{{ number_format($locataire->montant_loyer_ht * ($cc/100), 0, ',', ' ') }}</td>
            <td>{{ number_format($locataire->montant_loyer_ht * ($tva/100), 0, ',', ' ') }}</td>
            <td class="total">{{ number_format($montant_ttc, 0, ',', ' ') }}</td>
        </tr>
    </table>

    <div class="amount">Montant Net à Payer : {{ number_format($montant_ttc, 0, ',', ' ') }} F CFA</div>

    <!-- Table pour afficher le solde total -->
    <table>
        <tr>
            <td colspan="2">Solde à ce jour</td>
            <td>{{ number_format($transactions->sum('debit') - $transactions->sum('credit'), 0, ',', ' ') }} F CFA</td>
        </tr>
    </table>

    <div class="signature">Comptabilité</div>

    <div class="footer"></div>

</body>
</html>