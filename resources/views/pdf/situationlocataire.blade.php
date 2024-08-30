@extends('pdf.layouts.layout-export2')

@section('title', "Situation du locataire")

@section('content')
    <table style="border: none; margin-top:50px; font-size: 11px">
        <tr style="border: none">
            <td style="border: none">
                <div>
                    <p style="text-align:left; line-height:5px">Dakar, Senegal</p>
                    <p style="text-align:left; line-height:5px">+221 33 889 88 06</p>
                    <p style="text-align:left; line-height:5px">+221 33 823 40 53</p>
                </div>
            </td>
            <td style="border:none;">
                <div style="border-left: 3px solid black; padding-left: 10px;">
                    <p style="text-align:left; line-height:5px;">www.imalga@orange.sn</p>
                    <p style="text-align:left; line-height:5px;">Instagram: @imalga</p>
                    <p style="text-align:left; line-height:5px;">Facebook: imalga Sénégal</p>
                </div>
            </td>
        </tr>
    </table>

    @if(!empty($records))
        <h2 style="margin:0; color: #4CAF50;">IMMEUBLE {{ $locataire->bien_immo->nom_immeuble }}</h2>
        <h4 style="margin:0; color: #2196F3;">
            Du {{ $start }} au {{ $end }}
        </h4>
        <p style="margin:0; color: #2196F3;">
            Nom: {{ $locataire->nom }} <br>
            Prénom: {{ $locataire->prenom }} <br>
            Téléphone: {{ $locataire->telephone }}
        </p>
        <br>
        <h4 style="margin:0; color: #2196F3;">Du {{ $start }} au {{ $end }}</h4>
        <br>

        <h3 style="color: #4CAF50;">Situation Détaillée</h3>
        <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
            <thead>
                <tr style="background-color: #f2f2f2; color: #333;">
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;"><center>Date</center></th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;"><center>Libellé</center></th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;"><center>Débit</center></th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;"><center>Crédit</center></th>
                    <th style="padding: 10px; border: 1px solid #ddd; text-align: left;"><center>Solde</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr style="background-color: #fff;">
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['date'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['libelle'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; color: #f44336;">{{ $record['debit'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; color: #4CAF50;">{{ $record['credit'] }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['balance'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Total Débits</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{\App\Models\Outil::formatPrixToMonetaire($totalDebits, false, false) }}</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Total Crédits</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{\App\Models\Outil::formatPrixToMonetaire($totalCredits, false, false)  }}</td>
                </tr>
                <tr style="background-color: #FFC107;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Solde Final</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{ \App\Models\Outil::formatPrixToMonetaire($balance, false, true) }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <p>Aucune donnée disponible pour le locataire sélectionné.</p>
    @endif

    <br><br><br><br>
    <pre>
        Caissier          Chef d'Agence            Comptable
    </pre>
@endsection