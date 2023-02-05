@extends('pdf.layouts.layout-export2')
@section('title', "PDF Grand journal")
@section('content')
    <table style="border: none; margin-top:50px;font-size: 11px">
        <tr  style="border: none">
            <td  style="border: none">
                <div style="" >
                    <p  style="text-align:left;line-height:5px"> Dakar, Senegal </p>
                    <p style="text-align:left;line-height:5px"> +221 33 889 88 06</p>
                    <p style="text-align:left;line-heightp:5px"> +221 33 823 40 53</p>
                </div>
            </td>

            <td style="border:none;">
                <div style="border-left: 3px solid black">
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">www.imalga@orange.sn</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Instagram:  @imalga</p>
                    <p style="text-align:left ; margin-left:15px;line-height:5px ">Facebook:  imalga Sénégal</p>
                </div>
            </td>
        </tr>
    </table>

    <h2 style="margin:0">Grand Journal du {{$start}} au {{$end}}</h2>
    <br>
    <table>{{$solde = 0}}
        <tr>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">Dates</th>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">No pieces</th>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">Code Locataire/Proprietaire</th>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">Libellés</th>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">Recettes</th>
            <th style="padding-bottom: 40px;padding-top: 10px;padding-left: 30px;padding-right: 20px;">Dépenses</th>
        </tr>
    <tbody>
        @foreach($detail_journals as $detail_journal)
            <tr>{{$solde = $solde + ($detail_journal["entree"] - $detail_journal["sortie"])}}
                <td style="font-size:11px;padding: 2px"> {{$detail_journal["created_at_fr"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$detail_journal["code"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{isset($detail_journal["locataire"]) ? $detail_journal["locataire"]["code"] : $detail_journal["proprietaire"]["code"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$detail_journal["libelle"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$detail_journal["entree"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$detail_journal["sortie"]}}</td>
            </tr>
        @endforeach 
        <tr><td colspan="7"><b>Solde = {{\App\Models\Outil::formatPrixToMonetaire($solde, false, true)}}</b></td></tr>
    </tbody>
</table>
<br><br><br><br>
<pre>    <u>Caissier</u>                 <u>Chef d'Agence</u>                    <u>Comptable</u></pre>
@endsection