<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Location</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            color: #000;
            line-height: 1.8;
            margin: 2cm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-top: 20px;
        }
        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 20px;
        }
        .signature-section {
            display: flex;
            justify-content: space-between;
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
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10pt;
            background-color: #f9f9f9;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>CONTRAT DE LOCATION</h1>
    </div>

    <div class="content">
        <p><strong>ENTRE LES SOUSSIGNÉS :</strong></p>
        <p>
            {{$locataire->bien_immo->proprietaire->prenom}} {{$locataire->bien_immo->proprietaire->nom}}, titulaire de la pièce d’identité numéro {{$locataire->CNI ? $locataire->CNI : '(A renseigner)'}}, représentée par la société « Bico », 
            immatriculée au registre du commerce de Dakar sous le numéro RC.DKR.2023.A.43322, 
            représentée par M. Bocar Diong en qualité de Directeur,<br>
            Ci-après dénommée « le Bailleur »<br>
            <strong>D'une part</strong>
        </p>
        <p>
            Et :<br>
            {{$locataire->prenom}} {{$locataire->nom}}, né le {{$locataire->date_naissance ? $locataire->date_naissance : '(A renseigner)'}} à {{$locataire->lieu_naissance ? $locataire->lieu_naissance : '(A renseigner)'}} et titulaire de la CNI N° {{$locataire->CNI ? $locataire->CNI : '(A renseigner)'}}  de nationalité sénégalaise.<br>
            Numéro de téléphone : {{$locataire->telephone ? $locataire->telephone : '(A renseigner)'}}<br>
            Courriel : {{$locataire->email ? $locataire->email : '(A renseigner)'}} <br>
            Ci-après dénommé « le Preneur »
        </p>
        <p>
            <strong>Il a été convenu et arrêté ce qui suit :</strong>
        </p>

        <!-- Articles -->
        <div class="section">
            <p class="section-title">Article 1 : Objet et Désignation</p>
            <p>
                Le preneur accepte de prendre en location le local mis à sa disposition par le bailleur. Les locaux, objet 
                du présent bail, se situent à {{$locataire->bien_immo->proprietaire->adresse ? $locataire->bien_immo->proprietaire->adresse : '(A rensigner)'}} et se présentent comme suit :<br>
                {{$locataire->bien_immo->proprietaire->description ? $locataire->bien_immo->proprietaire->adresse : '(A renseigner ex: Chambre à coucher plus SDB - salon - cuisine - toilette visiteur équipé de chauffe-eau, espace familial 
                    au 4ème étage à gauche.)'}}
            </p>
        </div>
        <div class="section">
            <p class="section-title">Article 2 : Loyer</p>
            <p>
                Le présent bail est consenti moyennant un loyer mensuel de {{\App\Models\Outil::convertirNombreEnTexte($locataire->montant_loyer_ttc)}}
                ({{$locataire->montant_loyer_ttc}} TTC) payable au plus tard le 05 de chaque mois au siège situé à Ouagou Niayes 2 villa 
                numéro 34.
            </p>
        </div>
        <br><br><br>
        <div class="section">
            <p class="section-title">Article3 : CAUTION</p>
            <p>
            Le preneur devra verser entre les mains du bailleur, avant son entrée en jouissance des locaux, une somme non productible d'intérêt de deux cent vingt mille ( 220 000 ) _FCFA représentant la caution.
            NB : Cette caution sera payée avant l'entrée en possession des lieux.
            Cette caution est restituable en fin de bail au preneur sous réserve des conditions ci-
            après
            a) Le preneur doit restituer les lieux loués en parfaite état locatif et rendre les clefs au bailleur.
             téléphone.
            te pour répondre en tout temps du payement des loyers et des charges du bail.
            Le preneur devra également prendre toutes les dispositions pour amener la sécurité de son installation et de ses activités conformément à la règlementation.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article4 : PRISE D'EFFET ET PREAVIS</p>
            <p>
            a -PRISE D'EFFET
            Le bail est conclu pour une durée d’un an renouvelable, prend effet à partir du 05 décembre 2024 et prend fin le 05 décembre 2025 .
            Société Bâtiment immobilier construction BICO, OUAGOU Niayes 2 villa n°34 TEL :772501462 NINEA :0106884266- RC SN.DKR.2023.A.43322 mail : bico.sn@gmail.com
            b - PREAVIS
            Chacune des parties pourra y mettre fin en prévenant l'autre par lettre recommandée (accusé de réception) ou par voie extrajudiciaire, deux mois à l'avance pour le preneur et six mois à l'avance pour le bailleur.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 5 : PENALITES DE RETARD</p>
            <p>
                Tout retard accusé dans le paiement du loyer entrainera pour le locataire le paiement de pénalités de cinq mille francs CFA (5000) à partir du six (6) du mois en cours et ce, pour chaque jour de retard.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 6 : REMISE EN ETAT DES LIEUX</p>
            <p>
            Le preneur reconnait par la présente, prendre les lieux loués en bon état de réparation locative et s'engage sous réserve des dispositions de l'article 7 à les rendre à son état primitif au moment de son départ.
            Un état des lieux contradictoire sera établi entre les parties aussi bien à l'entrée qu'à la sortie des lieux du preneur.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 7 : TRANSFORMATION DES LIEUX</p>
            <p>
            Le preneur ne pourra faire aucun aménagement ou travaux sans l'accord ou le consentement officiel du bailleur. Tout embellissement ou amélioration accordé par le bailleur au preneur reviendra de plein droit au bailleur à la fin du bail. Le bailleur pourra toutefois exiger la remise immédiate des lieux en l’état, aux frais du Locataire, lorsque les transformations effectuées mettront en péril le bon fonctionnement des équipements ou la sécurité des lieux loués.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 8 : GARANTIE DES VICES</p>
            <p>
            Le bailleur doit garantir au preneur contre tous les vices ou dysfonctionnements portant sur les locaux qui en empêcheraient un usage normal alors même qu'il ne les aurait pas connus.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 9 : REPARATION_ ENTRETIEN</p>
            <p>
            Le preneur est tenu d'effectuer les réparations d'entretien des lieux loués. Il répond des dégradations ou des pertes dues à un défaut d'entretien au cours du bail.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article 10 : GROSSES REPARATIONS</p>
            <p>
            Le bailleur est tenu de procéder à ses frais dans les locaux remis en bail à toutes les grosses réparations devenues nécessaires et urgentes. Ces réparations sont celles des grands murs, des voûtes, des toitures, affaissements, étanchéité, des murs de soutènement et des fosses septiques.
            Lorsque le bailleur refuse ou tarde à faire procéder à l'exécution des travaux requis, le preneur peut, après avoir informé et présenté le devis estimatif au bailleur, faire réaliser lui-même les dits travaux.
            Société Bâtiment immobilier construction BICO, OUAGOU Niayes 2 villa n°34 TEL :772501462 NINEA :0106884266- RC SN.DKR.2023.A.43322 mail : bico.sn@gmail.com
            Les frais générés par ceux-ci seront intégralement déduits des loyers à échoir.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article11 : PRESCRIPTIONS ADMINISTRATIVES</p>
            <p>
            Le preneur devra satisfaire à toutes les prescriptions des services de police, de voierie et d'hygiène auxquelles les locations sont ordinairement astreintes afin qu'aucun recours ne puisse être exercé contre le bailleur ou le propriétaire des locaux remis à bail.
            </p>
        </div>

        <div class="section">
            <p class="section-title">Article12 : CONCLUSION</p>
            <p>
            Il est entendu que la présente location est régie par les dispositions civiles et commerciales de la République du Sénégal et aux textes subséquents notamment la loi du 84-12 du 04 Janvier 1984 et de la loi 98-21 du 26 mars 1998 modifiant les dispositions du code des obligations civiles et commerciales et de l'acte uniforme de l'OHADA.
            Compétence est expressément donnée au juge des référés du Tribunal Régional Hors classe de Dakar pour prononcer la résiliation du bail.
            Les frais, les timbres et l'enregistrement sont à la charge du locataire. Aucune commission ne sera remboursée en cas de désistement.
            </p>
        </div>
        
        <!-- Signature -->
        <div class="signature-section">
        <strong class="signature-left">
             Le Bailleur : <br>
             Société BICO
        </strong>
        <strong class="signature-right">
            Le Preneur : <br>
            Aly Thierry Ndiaye
        </strong>
        <br><br><br><br>
        <p>Fait à Dakar (Sénégal), le 08 novembre 2024</p>
        <p>En trois exemplaires</p>
    </div>
    </div>
</body>
</html>
