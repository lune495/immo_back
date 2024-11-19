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

        .title{
            font-family: 'Times New Roman', Times, serif;
            /* font-size: 14pt; */
            text-transform: uppercase;
            text-align: left;
            margin-top: 10px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header h1 {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
        }

        .header h3 {
            font-size: 10pt;
            font-weight: bold;
        }

        .header p {
            font-size: 11pt;
            margin: 5px 0;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            text-decoration: underline;
            margin-top: 20px;
        }

        .content {
            text-align: justify;
        }

        .content p {
            margin: 10px 0;
        }

        .content .bold {
            font-weight: bold;
        }

        .signature-section {
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
    </style>
</head>

<body>
    @if($user->structure->tag_logo)
        <div style=" text-align: center; margin-bottom: 1px;">
            <img src="{{ asset('app-assets/assets/images/' . $user->structure->tag_logo) }}" alt="Bannière" class="banner" style="width: 500px; max-width: 100%; height: auto;">
        </div>
    @endif
    <div class="header">
        <!-- <img src="logo.png" alt="Logo de la Compagnie Immobilière du Sénégal"> -->
        <h3>LOCATIONS – GERANCE – ACHATS – VENTES – CONSTRUCTION RENOVATION</h3>
        <h3><span class="bold">NINEA :</span> 009 989 130 RC: SN-DKR-2023-B-792</h3>
        <h3><span class="bold">ADRESSE :</span> OUEST FOIRE, TALI WALY villa n°21</h3>
        <h3><span class="bold">TEL :</span> 33 867 16 86 / 78 596 31 31 / 75 100 42 45</h3>
        <h3><span class="bold">EMAIL :</span> contact@cis-immobiliere.sn</p>
        <br>
        <h1>CONTRAT DE LOCATION</h1>
    </div>

    <div class="content">
    <p><span class="bold">Les soussignés : </span><span class="bold">{{$locataire->bien_immo->proprietaire->prenom}} {{$locataire->bien_immo->proprietaire->nom}}</span>, représentant de la <span class="bold">COMPAGNIE IMMOBILIÈRE DU SÉNÉGAL (C.I.S)</span>, immatriculée sous le numéro SN-DKR-2023-B-792, habilitée à représenter la Propriétaire en vertu du Mandat d’administration de biens.</p>
        <p>Ci-après dénommée <span class="bold">"la bailleresse"</span> d’une part, et</p>
        <p><span class="bold">{{$locataire->prenom}} {{$locataire->nom}}</span> né(e) le 31/07/1984 à NGUIDILE, titulaire de la CDI n° {{$locataire->CNI}} délivrée le 12/08/2021.</p>
        <p>Ci-après dénommé <span class="bold">"le preneur"</span> d’autre part.</p>

        <p class="section-title">IL A ÉTÉ CONVENU ET ARRÊTÉ CE QUI SUIT :</p>

        <p>Compagnie Immobilière du Sénégal (C.I.S) bailleresse, donne par les présentes en location pour le temps aux charges et conditions ci-après fixées à :</p>

        <p><span class="bold">{{$locataire->prenom}} {{$locataire->nom}}</span>, qui accepte les locaux dont la désignation suit :</p>

        <ul>
            <li><span class="bold">DESIGNATION :</span> Il s’agit d’un {{$locataire->descriptif_loyer}}</li>
            <li><span class="bold">USAGE : </span> {{\App\Models\Outil::toutEnMajuscule($locataire->type_location)}}</li>
            <li><span class="bold">ADRESSE :</span> CITE DJILY MBAYE.</li>
            <li><span class="bold">DUREE DU BAIL :</span> </li>
        </ul>
        <p>
        Le présent bail est consenti et accepté pour une durée d’un (1) an renouvelable.
Prenant effet le 01/11/2024 chacune des parties à la faculté de résilier le présent contrat en servant à son cocontractant un préavis de congé par lettre recommandée A.R ou acte extra judiciaire.
La période de préavis est fixée à six (6) mois pour le bailleur et deux (02) mois pour le locataire.
        </p>
        <br>
        <ul>
            <li><span class="bold">CHARGES ET CONDITIONS :</span></li>
        </ul>
        <p>
        La présente location est consentie et acceptée sous mes charges et conditions ordinaires de droit suivant l’usage sur place et conditions suivantes que le bailleur et le preneur s’engagent à respecter sous peine de résiliation du bail.</p>
        <p>
 Art 1 : Le preneur prendra les lieux loués dans l’état où ils se trouveront, étant précisé qu’ils lui seront livrés en bon état ainsi que les appareils et les installations (Compteur SEN’EAU et SENELEC).</p>
 <p>
 Art 2 : Le preneur entretiendra les lieux loués pendant toute la durée du bail pour les rendre dans l’état où ils se trouvaient lors de son entrée en jouissance. Le preneur devra sauf spécification contrainte maintenir lesdits lieux en bon état et effectuer les préparations locatives tout au long de la durée de ce bail, sauf en ce qui concerne l’usure normale et raisonnable du temps et les dommages causés par les éléments. </p>
 <p>
 Art 3 :      a) Le preneur tiendra les lieux loués constamment ou autres en quantité et de valeurs suffisantes pour répondre en tout temps du paiement des loyers au plus tard le 05 de chaque mois, charges et conditions de location.</p>
 <p>
 b) Le locataire doit se présenter au plus tard le 05 du mois pour payer le loyer. Tout retard de loyer peut engendrer des frais de déplacement. </p>
 <p>
 Art 4 : le preneur renonce en cas de vol ou d’infraction dans les lieux loués à tout recours contre le bailleur. </p>
 <p>
 Art 5 : Le preneur s’engage à ne pouvoir sans consentement du bailleur et par écrit, rien changer dans la disposition ou dans l’affectation des lieux loués.</p>
 <p>
 Art 6 : Le preneur s’engage à ne pas sous-louer ou de céder son droit au présent contrat suivant les dispositions de la loi n°99-70 du 13 Juillet 1966.</p>
 <p>
 Art 7 : Le preneur lorsqu‘il aura reçu ou donné congé, le bailleur pourra faire mettre un écriteau à l’emplacement de son choix indiquant que les lieux sont loués. Le preneur devra laisser visiter tous les jours ouvrables sur rendez-vous. </p>
 <p>
 Art 8 : Le preneur versera un (1) mois de caution et un (1) mois de loyer d’entrée comme garanti du paiement des réparations locatives, de la reprise de la peinture afin que l’appartement soit remis dans le même état que lors de la signature du contrat la même qualité d’enduit et de peinture que celle utilisée lors de sa rentrée. La caution ne peut en aucun cas servir de loyer après le préavis. Elle sera restituée au preneur après constat de remise en état parfait (réparation, peinture des lieux loués et après présentation des quitus de résiliation SENELEC, SONATEL, SEN’EAU.
 Pour rappel, le préavis est (02) mois fermes sans négociation. Si le locataire veut partir sans préavis, il ne peut réclamer sa caution ; il la perd d’office. <br>
 b) La caution ne peut pas remplacer le loyer.</p>
 <p>
 Art 9 : Le preneur remettra au bailleur le jour de l’expiration du bail les clefs qui lui seront été remises à l’entrée dans les lieux. </p>
 <p>
 Art 10 : conformément à la loi, un état des lieux contradictoires sera établi lors de la remise des clefs au locataire et lors de leur restitution. A défaut il pourra être établi par huissier à l’initiative de la partie la plus diligente, les frais étant partagés à moitié.</p>
 <p>
 Art 11 : Le preneur, dans le but de maintenir l’état des lieux, se réserve le droit d’entrer dans les lieux pour inspecter et effectuer les réparations nécessaires, pour autant qu’une telle entrée soit faite à un moment préalablement rangé avec l’accord du preneur. <p>
<p>
 Art 12 : a- Le bailleur sera responsable, des dépenses comme : les gros entretiens, travaux sur la construction, réparations sur les murs de plafonds, sol, fondation.
 ​b -  les locataires cotisent pour les dépenses telles que les vidanges des fosses septiques et le ramassage des ordures …   <p>
<p>
 Art 13 : Il interdit de vendre des boissons alcoolisées, ou utiliser les locaux comme une maison de passe, le constat de l’utilisation de chanvre indien dans la maison ou l’utilisation des locaux à des fins commerciaux au lieu à l’usage d’habitation ainsi que l’appartenance du locataire aux réseaux de drogue, prostitution proxénétisme, élévation des moutons et des chiens, rendra automatiquement le présent contrat caduc. Il est aussi porté à la connaissance du locataire que l’incompatibilité d’humeur entre les deux parties, l’abus de sonorisation troublant le repos des voisins, le surpeuplement des locaux auront les mêmes conséquences. <p>
<p>
 Art 14 : Tout mois entamé est du. <br>
 1- LOYER :
 Le présent bail est consenti moyennant un loyer de :
 <ul>
    <li>Loyer de base : {{number_format($locataire->montant_loyer_ht, 0, ',', ' ')}} F.CFA</li>
    @php
    $tva= null;
    $tom= null;
    @endphp
    @foreach($locataire->locataire_taxes as $t)
        @if($t->taxe->nom == 'TVA')
            @php $tva = ($locataire->montant_loyer_ht * $t->taxe->value) / 100; @endphp
        @elseif($t->taxe->nom == 'TOM')
            @php $tom = ($locataire->montant_loyer_ht * $t->taxe->value) / 100; @endphp
        @endif
    @endforeach
           <li>TVA 18% :  {{number_format($tva, 0, ',', ' ')}}</li>
           <li>TOM 3.6% : {{number_format($tom, 0, ',', ' ')}}</li>
           <li>CHARGES DIVERSES 3.6% : </li>
 </ul>
 <strong>TOTAL : {{number_format($locataire->montant_loyer_ht+$tva + $tom, 0, ',', ' ')}}F. CFA HT</strong>
 </p>
  <p>
 <div class= "title"> 2- CLAUSE RESOLUTOIRE : </div>
 A défaut de paiement d’un seul terme de loyer à son échéance, le bailleur assignera le preneur devant les tribunaux compétents, la présente location sera résiliée et le locataire sera expulsé sur simple ordonnance de référée, ladite ordonnance ayant pour objet, non de prononcer la résiliation qu’a lieu de plein droit d’en assurer l’exécution. <p>
    <p>
 <div class="title"> 3- ELECTION DE DOMICILE : </div>
 </p>
 Le preneur : dans le local loué.    
        </p>
    </div>
    <div class="signature-right">Fait à Dakar le 21/10/2024</div>
    <div class="signature-section">
        <strong class="signature-left"><u> COMPAGNIE IMMOBILIERE DU SENEGAL</u></strong>
        <strong class="signature-right">LE PRENEUR</strong>
    </div>
</body>
</html>