@extends('pdf.layouts.layout-export2')

@section('title', 'Situation Générale du Propriétaire')

@section('content')
    <div style=" text-align: center; margin-bottom: 1px;">
        <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner" style="width: 500px; max-width: 100%; height: auto;">
    </div>
    <table style="width: 100%; border: none; margin-top:50px; font-size: 11px;">
        <tr>
            <td style="border: none; width: 70%;">
                <p><strong>Nom du Propriétaire :</strong> {{ $nomProprietaire }} {{ $prenomProprietaire }}</p>
                <p><strong>Total Debits :</strong> {{ number_format($totalDebits, 2, ',', ' ') }} FCFA</p>
                <p><strong>Total Crédits :</strong> {{ number_format($totalCredits, 2, ',', ' ') }} FCFA</p>
                <p><strong>Solde :</strong> {{ number_format(($totalDebits - $totalCredits), 2, ',', ' ') }} FCFA</p>

            </td>
            <td style="border: none; width: 30%; text-align: right;">
                <p style="text-align: right;">{{$user->structure->adresse_structure ? $user->structure->adresse_structure : ''}}</p>
                <p style="text-align: right;">{{$user->structure->numero_tel1_structure ? $user->structure->numero_tel1_structure : ''}}</p>
                <p style="text-align: right;">{{$user->structure->numero_tel2_structure ? $user->structure->numero_tel2_structure : ''}}</p>
            </td>
        </tr>
    </table>

    <h2 style="color: #4CAF50; margin-top: 20px;">Situation Générale du proprietaire</h2>
    <table style="width: 100%; border-collapse: collapse; font-size: 10px; margin-top: 10px;">
        <thead>
            <tr style="background-color: #f2f2f2; color: #333;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Nom</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Prénom</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total Débits (FCFA)</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Total Crédits (FCFA)</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: right;">Solde</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($locataires as $locataire)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $locataire->nom }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $locataire->prenom }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($locataire->total_debit, 2, ',', ' ') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format($locataire->total_credit, 2, ',', ' ') }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right;">{{ number_format(($locataire->total_debit - $locataire->total_credit), 2, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br><br><br>
    <pre>
     <u>Caissier</u>               <u>Chef d'Agence</u>                  <u>Comptable</u>
    </pre>
@endsection
