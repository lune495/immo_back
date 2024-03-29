    <html>
        <head>
            <title>
                @yield('title')
            </title>
            <style>
                .text-uppercase
                {
                    text-transform: uppercase;
                }
                .table {
                    width: 100%;
                    margin-bottom: 1rem;
                    background-color: transparent;
                }

                .table th,
                .table td {
                    padding: 0.55rem;
                    vertical-align: top;
                    border-top: 1px solid #e9ecef;
                }

                .table thead th {
                    background-color: black;
                    vertical-align: bottom;
                    border-bottom: 2px solid #e9ecef;
                    color: #d7d9f2;
                }

                .table tbody + tbody {
                    border-top: 2px solid #e9ecef;
                }

                .table .table {
                    background-color: #fff;
                }

                .table-sm th,
                .table-sm td {
                    padding: 0.3rem;
                }

                .table-bordered {
                    border: none;
                }

                .table-bordered th,
                .table-bordered td {
                    border: none;
                }

                .table-bordered thead th,
                .table-bordered thead td {
                    border-bottom-width: 2px;
                }

                .table-borderless th,
                .table-borderless td,
                .table-borderless thead th,
                .table-borderless tbody + tbody {
                    border: 0;
                }

                .table-striped tbody tr:nth-of-type(odd) {
                    background-color: rgba(0, 0, 0, 0.03);
                }
                td,
                th {
                    border: 1px solid rgb(190, 190, 190);
                    padding: 10px;
                }

                td {
                    text-align: center;
                }

                th[scope="col"] {
                    background-color: #696969;
                    color: #fff;
                }

                th[scope="row"] {
                    background-color: #d7d9f2;
                }

                table {
                    border-collapse: collapse;
                    border: 1px solid rgb(200, 200, 200);
                    letter-spacing: 1px;
                    font-family: sans-serif;
                    font-size: .8rem;
                }
                .text-center {
                    text-align: center;
                }
                .text-left {
                    text-align: left;
                }
                .text-right {
                    text-align: right;
                }
                /** Define now the real margins of every page in the PDF **/
                body {
                    margin-top: 1.3cm;
                    font-weight: 400;
                    background:  #fff;
                    color: black;
                    -webkit-print-color-adjust:  exact;
                }

                /** Define the header rules **/
                .header {
                    position: fixed;
                    height: 1.5cm;
                }

                /** Define the footer rules **/
                .footer {
                    position: fixed;
                    bottom: 0px;
                    height: 2.5cm;
                }
                .badge{
                    padding:.5em 2em !important;
                    color:black;
                    background:#f1f1f1;
                    max-width: 300px !important;
                    border-radius:8px !important;
                    font-size:11px !important;
                }
                .mb-4{
                    margin-bottom: 5em;                }
                .mt-4{
                    margin-top: 2em;                }
            </style>
        </head>
        <body>

            <header class = "mb-4">
                <div class="header">
                   
                </div>
            </header>
             <img src="{{ asset('app-assets/assets/images/logo_saloum_digital.png') }}" style="margin-left:auto" style="margin-right:auto" alt="">
            <div class="mt-4">
                @yield('content')
            </div>

            <!--Footer page-->
            {{-- <div class="footer">
                <div style="font-size:12px;font-weight: bold; border: 1px solid black; padding: 5px ">
                    <p> 
                        <i> Toute marchandise commandée, livrée et non payée dans son intégralité reste propriété exclusive de FILIALE. Et FILIALE se donne le droit de récupérer sa marchandise si celle-ci n’est pas régularisé dans son intégralité sous 30 jours maximum à compter de la date d’achat de la facture. 
                        <br>
                        Tout montant versé en acompte n’est pas remboursable et fait office d’engagement d’achat auprès de FILIALE et reste propriété de FILIALE.   
                        </i> 
                    </p>
                </div>
                <hr>
                <div style="display:inline-flex" style="font-size:10px;">
                    <p class="text-left" style="font-size:10px; margin-top:1.5em"> RC: SN DKR 2014 A 1270</p>
                    <p class="text-right" style="margin-top:1.5em;font-size:10px;"> NINEA: 4982965 1A1 - Dakar</p>
                </div>
            </div> --}}
           
        </body>
    </html>
