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
            padding: 5px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row td {
            font-weight: bold;
            text-align: center;
        }
        .total-row td:last-child {
            text-align: center;
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
    @if($user->structure->tag_logo)
        <div style="text-align: center; margin-bottom: 1px;">
            <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" style="width: 500px; max-width: 100%; height: auto;">
        </div>
    @endif

    <div class="header">
        <h1>{{$user->structure->nom_structure}}</h1>
        <div class="contact-info">
            <p>L'IMMOBILIER GARANTI</p>
            <p>{{$user->structure->adresse_structure}}, Tel: {{$user->structure->numero_tel1_structure}} </p>
            <p>Email: {{$user->structure->email_structure}}</p>
        </div>
    </div>
    <center><p><u>SITUATION LOYER DU MOIS DE {{$mois}}</u></p></center>
    <u>Bailleur</u>: <strong>{{ $nom_proprio }}</strong>
    <table>
        <tr>
            <th>Nom Immeuble</th>
            <th>Valeur Locataive</th>
        </tr>

        @foreach($proprios as $proprio)
        <tr>
            <td>{{ $proprio->nom_immeuble}}</td>
            <td><strong>{{number_format($proprio->valeurLocative(), 0, ',', ' ') }} FCFA</strong></td>
        </tr>
         @endforeach
    </table>
    <table>
        <tr>
            <th>Bien. Immo</th>
            <th>Locataires</th>
            <th>Montants</th>
            <th>Impayé</th>
            <th>Mnt/Bien</th>
        </tr>

        @php $totalRecettes = 0; $totalcredits = 0; $totalsoldes = 0; $commission = 0; @endphp

        @foreach($locataires as $locataire)
            @php 
                $totalRecettes += $locataire->total_credit; 
                $totalcredits += $locataire->total_credit; 
                $commission = $locataire->commission_agence; 
                $totalsoldes += $locataire->solde;
            @endphp
        @endforeach

        @php $currentBien = null; @endphp

        @php

        $bienSums = $locataires->groupBy('nom_immeuble')->map(function($group) {
        return $group->sum('total_credit');
        });
        
        @endphp

        @foreach($locataires as $locataire)
            @if($locataire->nom_immeuble !== $currentBien)
                @php 
                    $currentBien = $locataire->nom_immeuble;
                    $bienTotal = $bienSums[$currentBien];
                @endphp
                <tr>
                    <td rowspan="{{ $locataires->where('nom_immeuble', $currentBien)->count() }}">{{ $currentBien }}</td>
                    <td>{{ $locataire->nom_complet }}</td>
                    <td>{{ number_format($locataire->total_credit, 0, ',', ' ') }}</td>
                    <td>{{ number_format($locataire->solde, 0, ',', ' ') }}</td>
                    <td rowspan="{{ $locataires->where('nom_immeuble', $currentBien)->count() }}">{{ number_format($bienTotal, 0, ',', ' ') }}</td>
                </tr>
                @else
                    <tr>
                        <td>{{ $locataire->nom_complet }}</td>
                        <td>{{ number_format($locataire->total_credit, 0, ',', ' ') }}</td>
                        <td>{{ number_format($locataire->solde, 0, ',', ' ') }}</td>
                    </tr>
                @endif
        @endforeach

        <tr class="total-row">
            <td>Reçu Total loyer</td>
            <td colspan="4">{{ number_format($totalRecettes, 0, ',', ' ') }}</td>
        </tr>
    </table>

    <h3><u>Dépenses :</u></h3>
    <table>
        @php $totalDepenses = 0; @endphp
        @foreach($sorties as $sortie)
            @php $totalDepenses += -1 * $sortie->montant_compte; @endphp
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $sortie->libelle }}</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format(-1 * $sortie->montant_compte, 0, ',', ' ') }}</td>
            </tr>
        @endforeach

        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">Honoraire d'agence ( {{$commission}}% de {{$totalRecettes}} )</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($honoraire, 0, ',', ' ') }}</td>
            @php $totalDepenses += $honoraire; @endphp
        </tr>
        
        @if($user->structure_id != 2)
        <tr>
            <td style="padding: 10px; border: 1px solid #ddd;">TVA 18% de ({{$honoraire}})</td>
            <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($honoraire * 0.18, 0, ',', ' ') }}</td>
            @php $totalDepenses += $honoraire + ($honoraire * 0.18); @endphp
        </tr>
        @endif

        <tr class="total-row">
            <td>Total Dépense</td>
            <td>{{ number_format($totalDepenses, 0, ',', ' ') }}</td>
        </tr>
    </table>

    <h3>À verser :</h3>
    <p>{{ number_format($totalRecettes, 0, ',', ' ') }} - {{ number_format($totalDepenses, 0, ',', ' ') }} F = {{ number_format($totalRecettes - $totalDepenses, 0, ',', ' ') }}</p>
    
    @if(($totalRecettes - $totalDepenses) < 0)
        <p>Le bailleur nous doit : {{ number_format($totalRecettes - $totalDepenses, 0, ',', ' ') }} F CFA</p>
    @endif
    
    <div class="signatures">
        <div><p>Dakar le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p></div>
        <div><p>LE BAILLEUR</p></div>
    </div>
</div>
</body>
</html>






