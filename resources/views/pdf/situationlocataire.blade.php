@extends('pdf.layouts.layout-export2')

@section('title', "Situation du locataire")

@section('content')
    <div style=" text-align: center; margin-bottom: 1px;">
        <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner" style="width: 500px; max-width: 100%; height: auto;">
    </div>
    <table style="border: none; margin-top:1px;font-size: 11px; width: 100%;">
        <tr style="border: none;">
            <td style="border: none;">
                <div>
                    <p style="text-align:left;line-height:5px">Adresse : {{$user->structure->adresse_structure ? $user->structure->adresse_structure : ''}}</p>
                    <p style="text-align:left;line-height:5px">Téléphone : {{$user->structure->numero_tel1_structure ? $user->structure->numero_tel1_structure : ''}}</p>
                    <!-- <p style="text-align:left;line-height:5px"> +221 33 823 40 53</p> -->
                </div>
            </td>
            <td style="border:none;">
                <div style="border-left: 3px solid black;">
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Site : {{$user->structure->site_structure}}</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Instagram: {{$user->structure->instagram_structure}}</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Facebook:  {{$user->structure->facebook_structure}}</p>
                </div>
            </td>
        </tr>
    </table>

    <!-- Vérifiez que les données du locataire sont bien transmises -->
    @if(!empty($locataire) && !empty($records))
        <h2 style="margin:0; color: #4CAF50;">IMMEUBLE {{ $locataire->bien_immo->nom_immeuble ?? 'N/A' }}</h2>
        <h4 style="margin:0; color: #2196F3;">
            Du {{ $start ?? 'N/A' }} au {{ $end ?? 'N/A' }}
        </h4>
        <p style="margin:0; color: #2196F3;">
            Nom: {{ $locataire->nom ?? 'N/A' }} <br>
            Prénom: {{ $locataire->prenom ?? 'N/A' }} <br>
            Téléphone: {{ $locataire->telephone ?? 'N/A' }}
        </p>
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
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['date'] ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['libelle'] ?? 'N/A' }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; color: #f44336;">{{ $record['debit'] ?? 0 }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd; color: #4CAF50;">{{ $record['credit'] ?? 0 }}</td>
                        <td style="padding: 10px; border: 1px solid #ddd;">{{ $record['balance'] ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Total Débits</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{ \App\Models\Outil::formatPrixToMonetaire($totalDebits ?? 0, false, false) }}</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Total Crédits</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{ \App\Models\Outil::formatPrixToMonetaire($totalCredits ?? 0, false, false) }}</td>
                </tr>
                <tr style="background-color: #FFC107;">
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="3">Solde Final</td>
                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;" colspan="2">{{ \App\Models\Outil::formatPrixToMonetaire($balance ?? 0, false, true) }}</td>
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