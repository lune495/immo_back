<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation Loyer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header .contact-info {
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row td {
            font-weight: bold;
        }
        .total-row td:last-child {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .signatures div {
            text-align: center;
            width: 45%;
        }
    </style>
</head>
<body>

<div class="container">
    <div style=" text-align: center; margin-bottom: 1px;">
        <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner" style="width: 500px; max-width: 100%; height: auto;">
    </div>
    <div class="header">
        <h1>{{$user->structure->nom_structure}}</h1>
        <div class="contact-info">
            <p>L'IMMOBILIER GARANTI</p>
            <p>{{$user->structure->adresse_structure}}, Tel: {{$user->structure->numero_tel1_structure}} </p>
            <p>Email: {{$user->structure->email_structure}}</p>
        </div>
    </div>
    <center><p><u>SITUATION LOYER DU MOIS DE {{$mois}}</u></p></center>
    <u>Bailleur</u> : <strong>{{ $nom_proprio }}</strong>

    <table>
        <tr>
            <th>Locataires</th>
            <th>Montants</th>
            <th>Impayé</th>
        </tr>
        @php $totalRecettes = 0; @endphp
        @php $totalcredits = 0; @endphp
        @php $totalsoldes = 0; @endphp

        @foreach($locataires as $locataire)
            @php $totalRecettes += $locataire->total_credit; @endphp
            @php $totalcredits += $locataire->total_credit; @endphp
        @php $totalsoldes += $locataire->solde; @endphp
        <tr>
            <td>{{ $locataire->nom_complet }}</td>
            <td>{{ number_format($locataire->total_credit, 0, ',', ' ') }} </td>
            <td>{{ number_format(-1 * $locataire->solde, 0, ',', ' ') }}</td>
        </tr>
        @endforeach
        <tr class="total-row">
            <td colspan="2">Reçu Total loyer</td>
            <td>{{ number_format($totalRecettes, 0, ',', ' ') }} </td>
        </tr>
    </table>

    <h3><u>Dépenses :</u></h3>
    <table>
        @php $totalDepenses = 0; @endphp
        @foreach($sorties as $sortie)
        @php $totalDepenses += -1 * $sortie->montant_compte; @endphp
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">{{$sortie->libelle}}</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format(-1 * $sortie->montant_compte, 0, ',', ' ') }} </td>
        </tr>
        @endforeach
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Honoraire d'agence ( x% de {{$totalRecettes}} )</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($honoraire, 0, ',', ' ') }} </td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">TVA 18% de ({{$honoraire}})</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($honoraire * 0.18, 0, ',', ' ') }} </td>
        </tr>
        <tr class="total-row">
            <td>Total Dépense</td>
            <td>{{ number_format($totalDepenses + $honoraire + ($honoraire * 0.18) , 0, ',', ' ') }} </td>
        </tr>
    </table>

    <h3>À verser :</h3>
    <p>{{ number_format($totalRecettes, 0, ',', ' ') }}   -  {{ number_format(($totalDepenses + $honoraire + ($honoraire * 0.18)), 0, ',', ' ') }} F = {{ number_format($totalRecettes - ($totalDepenses + $honoraire + ($honoraire * 0.18)), 0, ',', ' ') }} </p>

    <p>Le bailleur nous doit : {{ number_format($totalRecettes - ($totalDepenses + $honoraire + ($honoraire * 0.18)), 0, ',', ' ') }} F CFA</p>

    <div class="signatures">
        <div>
            <p>Dakar le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>
        <div>
            <p>LE BAILLEUR</p>
        </div>
    </div>
</div>

</body
</html>
