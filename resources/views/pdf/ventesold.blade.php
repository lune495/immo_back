 <!DOCTYPE html>
<html>
    <head>
        <style>
            /**
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
            @page {
                margin: 0cm;
            }
            @media print {
                html, body {
                    height: 100%;
                }
            }
            body {
                display: block;
                position: center;
                margin-top: 0cm;
                margin-left: 0.6cm;
                margin-right: 0.7cm;
                margin-bottom: 1cm;
                font-size: 0.6em;
                font: 16pt/1.5 'Raleway','Cambria', sans-serif;
                font-weight: 300;
                background:  #fff;
                color: black;
                -webkit-print-color-adjust:  exact;
                /*border:1px solid black;*/
            }
            section{
                margin-top: -2px;
                margin-bottom: -2px;
            }
            div{
            .droite{
                text-align:right;
                font-size: 0.75em;
                margin-top:-30px;
            }
            .gauche{
                text-align:left;
                font-size: 0.8em;
            }
            hr{
                border-top: 1px dotted red;
            }
            nav{
                /*border:1px solid black;*/
                margin-top:30px;
                float: center;
            }
            table {
                font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                margin-bottom: 5px;
            }
            td, th {
                text-align: center;
                font-size: 0.75em;
            }
            header{
                /*margin-left: auto;
                margin-right: auto;*/
            }
        </style>
    <head>
    <body>
        <div>
            <section class="droite" style="text-align: center">
                <header style="margin-top : 50px;font-size: 14px;">
                    <!-- Ticket De Caisse {{$id}} -->
                </header>
                <br>

                <div style="font-size: 20px;font-weight:bold">
                    <img src="{{asset('app-assets/assets/images/logo_saloum_digital.jpg')}}" style="width: 120px;"> <br>
                    <!--IMAARA-->
                </div>

                <div style="margin:10px 0">
                    Rue Serigne Abdou khadr, Keur Massar
                </div>
                <div style="margin:10px 0">
                    33 824 63 54
                </div>
                ************************
                <div style="margin:7px 0">
                    @if(isset($client["nom_complet"]))
                    {{$client["nom_complet"]}}
                    @else
                    Client de passage
                    @endif
                </div>
                <div style="margin:10px 0">
                </div>
                ************************

                <!-- <dt  style="font-size: 18px;font-weight:bold">Vente N°{{$id}}</dt> -->

                <dt  style="margin:10px 0">Date : {{date('d-m-Y H:i:s')}}</dt>
            </section>

            <section  style="margin-top : 30px">
                <table>
                    <tbody>
                    <tr>
                        <td style="width: 10%">Qte </td>
                        <td style="width: 60%">Produit </td>
                        <td style="width: 20%">Montant </td>
                    </tr>
                        @foreach($vente_produits as $vente)
                            <tr>
                                <td style="padding : 15px 0">  {{$vente["qte"]}}</span> </td>
                                <td style="padding : 15px 0"> {{ \App\Models\Outil::premereLettreMajuscule($vente["produit"]["designation"])}}</td>
                                <td style="padding : 15px 0">  {{\App\Models\Outil::formatPrixToMonetaire($vente["qte"]*$vente["prix_vente"], false, false)}} </td>
                                <td style="padding : 15px 0">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <div style="overflow: hidden;margin-top : 20px">**************************************</div>
            <section  style="overflow: hidden;margin-bottom : 20px">
                <table>
                    <tbody>
                    <tr>
                        <td style="width: 50%;text-align:left">Total </td>
                        <td style="padding : 10px 0;text-align:left">  {{\App\Models\Outil::formatPrixToMonetaire($montant, false, true)}}</td>
                    </tr>
                    </tbody>
                </table>
            </section>
            <div style="overflow: hidden;">**************************************</div>
            {{-- <div style="text-align:center;margin-bottom : 7px; margin-top : 7px;font-size: 12px">Reglé en {{$type_paiement["designation"]}}</div> --}}
            <div style=" overflow: hidden;margin-bottom : 7px; margin-top : 7px;">**************************************</div>
        </div>
    </body>
  <footer>
        <p style="font-size:10px">Vous avez été servi par:  {{$user["name"]}} </p>
</footer>
</html>
