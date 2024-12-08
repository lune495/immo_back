<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Situation Loyer</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
            table-layout: fixed;
        }
        th, td {
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
            word-wrap: break-word;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .section-title {
            margin-top: 20px;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 40px;
        }

        .signature-left {
            float: left;
            font-size: 9pt;
        }

        .signature-right {
            float: right;
            font-size: 9pt;
        }
    </style>
</head>
<body>
<div class="container">
    @if($user->structure->tag_logo)
        <div style="text-align: center; margin-bottom: 10px;">
            <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" style="width: {{$user->structure_id == 5 ? '200px' : '700px' }}; max-width: 100%; height: auto;">
        </div>
    @endif

    <!-- <div class="header" style="text-align: center; margin: 20px auto;">
        <h1>{{$user->structure->nom_structure}}</h1>
        <div class="contact-info">
            <p>L'IMMOBILIER GARANTI</p>
            <p>{{$user->structure->adresse_structure}}, Tel: {{$user->structure->numero_tel1_structure}}</p>
            <p>Email: {{$user->structure->email_structure}}</p>
        </div>
    </div> -->

    <center><p><u>SITUATION LOYER DU MOIS DE {{$mois}}</u></p></center>
    <u>Bailleur</u>: <strong>{{ $nom_proprio }}</strong>

    <!-- Première table -->
    <table>
        <thead>
            <tr>
                <th>Nom Immeuble</th>
                <th>Valeur Locative</th>
            </tr>
        </thead>
        <tbody>
        @foreach($proprios as $proprio)
            <tr>
                <td>{{ $proprio->nom_immeuble }}</td>
                <td><strong>{{ number_format($proprio->valeurLocative(), 0, ',', ' ') }} FCFA</strong></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Deuxième table -->
    <div class="section-title">Détail par immeuble :</div>
    @php
        $totalRecettes = 0;
        $totalDepenses = 0;
        $commission = 0;
    @endphp
    @foreach($locataires as $locataire)
            @php 
                $commission = $locataire->commission_agence;
            @endphp
        @endforeach
    <table>
        <thead>
            <tr>
                <th>Bien. Immo</th>
                <th>Locataires</th>
                <th>Montants</th>
                <th>Impayé</th>
            </tr>
        </thead>
        <tbody>
        @foreach($locataires->groupBy('nom_immeuble') as $immeuble => $locatairesGroup)
            <tr class="total-row">
                <td colspan="4"><strong>{{ $immeuble }}</strong></td>
            </tr>
            @php $immeubleTotal = 0; @endphp
            @foreach($locatairesGroup as $locataire)
                @php $immeubleTotal += $locataire->total_credit + $locataire->total_cc; @endphp
                <tr>
                    <td>{{ $immeuble }}</td>
                    <td>{{\App\Models\Outil::toutEnMajuscule($locataire->nom_complet)}}</td>
                    <td>{{ number_format($locataire->total_credit + $locataire->total_cc, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($locataire->solde, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total {{ $immeuble }}</td>
                <td colspan="2">{{ number_format($immeubleTotal, 0, ',', ' ') }} FCFA</td>
            </tr>
            @php $totalRecettes += $immeubleTotal; @endphp
        @endforeach

        <!-- Ligne du total général -->
        <tr class="total-row">
            <td colspan="2"><strong>Total Général</strong></td>
            <td colspan="2"><strong>{{ number_format($totalRecettes, 0, ',', ' ') }} FCFA</strong></td>
        </tr>
        </tbody>
    </table>
    <!-- Tableau des dépenses -->
    
    <h3><u>Dépenses :</u></h3>
    <table>
        @php $totalDepenses = 0; @endphp
        @foreach($sorties as $sortie)
            @php $totalDepenses += (-1 * $sortie->montant_compte); @endphp
            <tr>
                <td>{{\App\Models\Outil::toutEnMajuscule($sortie->libelle)}}</td>
                <td>{{ number_format(-1 * $sortie->montant_compte, 0, ',', ' ') }}</td>
            </tr>
        @endforeach
      @if($commission > 1 && $commission <= 50)
        <tr>
            <td>Honoraire d'agence ( {{$commission}}% de  {{$totalRecettes}})</td>
            <td>{{ number_format(($commission * $totalRecettes)/100, 0, ',', ' ') }}</td>
            @php $totalDepenses += (($commission * $totalRecettes)/100); @endphp
        </tr>
        @endif

        @if($commission > 50)
        <tr>
            <td>Honoraire d'agence ( {{$commission}} )</td>
            <td>{{ number_format($commission, 0, ',', ' ') }}</td>
            @php $totalDepenses += $commission; @endphp
        </tr>
        @endif
      @if($user->structure_id != 3 && $user->structure_id != 5)
        @if($commission > 50)
            <tr>
                <td>TVA 18% de {{$commission}}</td>
                <td>{{ number_format($commission * 0.18, 0, ',', ' ') }}</td>
                @php $totalDepenses += ($commission * 0.18); @endphp
            </tr>
        @endif
        @if($commission > 1 && $commission <= 50)
        <tr>
                <td>TVA 18% de {{($commission * $totalRecettes)/100}}</td>
                <td>{{ number_format((($commission * $totalRecettes)/100) * 0.18, 0, ',', ' ') }}</td>
                @php $totalDepenses += ((($commission * $totalRecettes)/100) * 0.18); @endphp
         </tr>
        @endif
      @endif
        <tr class="total-row">
            <td>Total Dépenses</td>
            <td>{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</td>
        </tr>
    </table>
    <h3>À verser :</h3>
    <p>{{ number_format($totalRecettes, 0, ',', ' ') }} - {{ number_format($totalDepenses, 0, ',', ' ') }} F = {{ number_format($totalRecettes - $totalDepenses, 0, ',', ' ') }} FCFA</p>

    @if(($totalRecettes - $totalDepenses) < 0)
        <p>Le bailleur nous doit : {{ number_format(abs($totalRecettes - $totalDepenses), 0, ',', ' ') }} F CFA</p>
    @endif
    <div class="signature-section">
        <strong class="signature-left"><u> COMPAGNIE IMMOBILIERE DU SENEGAL</u></strong>
        <strong class="signature-right">LE PRENEUR</strong>
    </div>
</div>
</body>
</html>
