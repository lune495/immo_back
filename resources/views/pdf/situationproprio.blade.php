@extends('pdf.layouts.layout-export2')
@section('title', "Situation du propriétaire")
@section('content')
    <table style="border: none; margin-top:50px;font-size: 11px">
        <tr style="border: none">
            <td style="border: none">
                <div>
                    <p style="text-align:left;line-height:5px"> Dakar, Senegal </p>
                    <p style="text-align:left;line-height:5px"> +221 33 889 88 06</p>
                    <p style="text-align:left;line-height:5px"> +221 33 823 40 53</p>
                </div>
            </td>
            <td style="border:none;">
                <div style="border-left: 3px solid black; padding-left: 10px;">
                    <p style="text-align:left; line-height:5px;">www.imalga@orange.sn</p>
                    <p style="text-align:left; line-height:5px;">Instagram:  @imalga</p>
                    <p style="text-align:left; line-height:5px;">Facebook:  imalga Sénégal</p>
                </div>
            </td>
        </tr>
    </table>
    @php $totalRecettes = 0; @endphp
    @php $totalDepenses = 0; @endphp
    @if(!empty($entrees['data']['journal_proprios']))
        @php
            $proprietaire = $entrees['data']['journal_proprios'][0]['locataire']['bien_immo']['proprietaire'];
            $nomCompletProprietaire = $proprietaire['prenom'] . ' ' . $proprietaire['nom'];
        @endphp

        <h2 style="margin:0; color: #4CAF50;">Situation du propriétaire: {{ $nomCompletProprietaire }}</h2>
        <h4 style="margin:0; color: #2196F3;">Du {{ $start }} au {{ $end }}</h4>
        <br>

        <h3 style="color: #4CAF50;">Tableau des Recettes</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Libellé</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Montant</th>
                </tr>
            </thead>
            <tbody>

                @foreach($entrees['data']['journal_proprios'] as $entree)
                    @php $totalRecettes += $entree['entree']; @endphp
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $entree['libelle'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $entree['entree'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Total Recettes</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ $totalRecettes }}</td>
                </tr>
            </tfoot>
        </table>
        <br>
    @endif
    @if(!empty($sorties))
        <h3 style="color: #f44336;">Tableau des Dépenses</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Libellé</th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sorties as $sortie)
                    @php $totalDepenses += $sortie; @endphp
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd;">Sortie</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $sortie }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Total Dépenses</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ $totalDepenses }}</td>
                </tr>
            </tfoot>
        </table>
        <br>
    @endif
        <h3 style="color: #FF9800;">Solde Final</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Solde</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">{{ \App\Models\Outil::formatPrixToMonetaire($totalRecettes - $totalDepenses, false, true) }}</td>
                </tr>
            </tbody>
        </table>
    @if(empty($entrees['data']['journal_proprios']) && empty($sorties))
        <p>Aucune donnée disponible pour le propriétaire sélectionné.</p>
    @endif

    <br><br><br><br>
    <pre>
        Caissier          Chef d'Agence            Comptable
    </pre>
@endsection