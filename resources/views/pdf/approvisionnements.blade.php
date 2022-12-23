@extends('pdf.layouts.layout-export2')
@section('title', "PDF Facture commande")
@section('content')
    <table style="border: none; margin-top:50px;font-size: 11px">
        <tr  style="border: none">
            <td  style="border: none">
                <div style="" >
                    <p  style="text-align:left;line-height:5px"> Dakar, Senegal </p>
                    <p style="text-align:left;line-height:5px"> +221 33 889 88 06</p>
                    <p style="text-align:left;line-height:5px"> +221 33 823 40 53</p>
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

    <h2 style="margin:0">Grand Journal </h2>
    <p style="text-align:left;line-height:15px">Test</p>
    <br>
    <table>
        <tr>
            <th>Produit</th>
            <th>Qté</th>
            <th>P U</th>
            <th>Remise</th>
            <th>Montant HT</th>
        </tr>
    {{-- <tbody style="border:none">
        @foreach($ligne_approvisionnements as $ligne_approvisionnement)
            <tr style="padding:0px">
                <td style="font-size:11px;padding: 2px"> {{$ligne_approvisionnement["produit"]["designation"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$ligne_approvisionnement["quantity_received"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{$ligne_approvisionnement["produit"]["pa"]}}</td>
                <td style="font-size:11px;padding: 2px"> {{0}}</td>
                <td style="font-size:11px;padding: 2px">{{\App\Models\Outil::formatPrixToMonetaire($ligne_approvisionnement["quantity_received"]*$ligne_approvisionnement["produit"]["pa"], false, false)}}</td>
            </tr>
        @endforeach

        <!--total-->
        <tr>
            <td colspan="1" style="border-left: 2px solid white;border-bottom: 2px solid white"></td>
            <td>
                <div>
                    <p class="badge" style="line-height:15px;font-size:9px!important">Total TTC</p>
                    <p style="line-height:5px">{{ \App\Models\Outil::formatPrixToMonetaire($montant, false, true)}}</p>
                </div>
            </td>
            <td>
                <div>
                    <p class="badge" style="line-height:15px"> Remise</p>
                    <p style="line-height:5px">0</p>
                </div>
            </td>
            <td>
                <div>
                    <p class="badge" style="line-height:15px">tva</p>
                    <p style="line-height:5px">0</p>
                </div>
            </td>
            <td style="font-weight: bold;font-size: 14px"> 
                <div>
                    <p class="badge">Net a payer</p>
                    <p style="line-height:5px">{{ $montant}}</p>
                </div> 
            </td>
            <td style="font-weight: bold;font-size: 14px">  </td>
        </tr>
        <tr>
            <td colspan="2"  style="padding-top : 10px;font-weight: bold;font-size: 11px">Conditions Reglement</td>
            <td style="padding-top : 10px;font-weight: bold;font-size: 11px"> {{$created_at_fr}} </td>
            <td style="padding-top : 10px;font-weight: bold;font-size: 11px"> ESP</td>
            <td style="padding-top : 10px;font-weight: bold;font-size: 11px"> {{\App\Models\Outil::formatPrixToMonetaire($montant, false, true)}} </td>
        </tr>
        
    </tbody> --}}
</table>
@endsection