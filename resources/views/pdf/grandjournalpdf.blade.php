@extends('pdf.layouts.layout-export2')
@section('title', "PDF Grand journal")

@section('content')
    @if($user->structure->tag_logo)
    <div style="width: 100%; text-align: center; margin-bottom: 1px;">
            <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner">
    </div>
    @endif
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

    <h2 style="margin:0; text-align:center; color:#2E8B57;">Caisse du {{$start}} au {{$end}}</h2>
    <br>
    <table style="width: 100%; border-collapse: collapse;">
        {{$solde = 0}}
        <thead style="background-color: #2E8B57; color: white;">
            <tr>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">Dates</th>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">No pièces</th>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">Code Locataire/Propriétaire</th>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">Libellés</th>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">Recettes</th>
                <th style="padding: 12px; border: 1px solid #dddddd; text-align: left;">Dépenses</th>
            </tr>
        </thead>
        <tbody>
        @if(!empty($detail_journals))
            @foreach($detail_journals as $index => $detail_journal)
                <tr style="background-color: {{ $index % 2 == 0 ? '#f2f2f2' : '#ffffff' }};">
                    {{$solde = $solde + ($detail_journal["entree"] - $detail_journal["sortie"])}}
                    <td style="padding: 8px; border: 1px solid #dddddd;">{{$detail_journal["created_at_fr"]}}</td>
                    <td style="padding: 8px; border: 1px solid #dddddd;">{{$detail_journal["code"]}}</td>
                    <td style="padding: 8px; border: 1px solid #dddddd;">
                        {{isset($detail_journal["locataire"]) ? $detail_journal["locataire"]["code"] : $detail_journal["proprietaire"]["code"]}}
                    </td>
                    <td style="padding: 8px; border: 1px solid #dddddd;">{{$detail_journal["libelle"]}}</td>
                    <td style="padding: 8px; border: 1px solid #dddddd;">{{$detail_journal["entree"]}}</td>
                    <td style="padding: 8px; border: 1px solid #dddddd;">{{$detail_journal["sortie"]}}</td>
                </tr>
            @endforeach 
        @else
            <tr>
                <td colspan="6" style="padding: 12px; border: 1px solid #dddddd; text-align: center;">Aucune donnée disponible pour cette date sélectionnée.</td>
            </tr>
        @endif
        <tr>
            <td colspan="6" style="padding: 12px; border: 1px solid #dddddd; text-align: right;"><b>Solde = {{\App\Models\Outil::formatPrixToMonetaire($solde, false, true)}}</b></td>
        </tr>
        </tbody>
    </table>
    <br><br><br><br>
    <pre style="text-align: center;">    <u>Caissier</u>                 <u>Chef d'Agence</u>                    <u>Comptable</u></pre>
@endsection
