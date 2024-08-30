<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis Professionnel</title>
    <style>
        /* Général */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Assure que le body prend au moins la hauteur de la fenêtre */
        }

        header {
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header .logo img {
            width: 150px;
        }

        header .company-info {
            margin-top: 10px;
        }

        header h1 {
            margin: 0;
        }

        .client-info, .project-info {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .client-info h2, .project-info h2 {
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .project-info h3 {
            margin-top: 20px;
        }

        .project-info ul {
            list-style: square;
            margin-left: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tfoot th {
            background-color: #ddd;
        }

        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <!-- <img src="{{ public_path('images/logo.png') }}" alt="Logo de l'entreprise"> -->
        </div>
        <div class="company-info">
            <h1>Devis Professionnel</h1>
            <p>Entreprise Golden Tech</p>
            <p>Adresse : 250 GY, 11500 Dakar</p>
            <p>Téléphone : +221 77 176 64 28 / +221 77 507 36 20</p>
            <p>Email : badaralune9@gmail.com</p>
        </div>
    </header>

    <section class="client-info">
        <h2>Informations sur le Client</h2>
        <p><strong>Nom :</strong> ###########</p>
        <p><strong>Adresse :</strong> #################</p>
        <p><strong>Téléphone :</strong> ################</p>
        <p><strong>Email :</strong> ###################</p>
    </section>

    <section class="project-info">
        <h2>Détails du Projet</h2>
        <h3>1. Introduction</h3>
        <p>Développement d'une plate-forme web pour la gestion des badges d'immeubles.</p>

        <h3>2. Objectifs</h3>
        <ul>
            <li>Permettre le transfert de badges d’immeubles à distance.</li>
            <li>Offrir une interface pour la sauvegarde et l’envoi dématérialisé des badges.</li>
            <li>Intégrer des technologies NFC et RFID pour le transfert.</li>
            <li>Assurer la compatibilité avec les systèmes d’exploitation Mac et Windows.</li>
            <li>Prévoir une évolution vers une version mobile pour smartphones.</li>
        </ul>

        <h3>3. Fonctionnalités</h3>
        <ul>
            <li>Interface Utilisateur : Tableau de bord, Gestion des badges, Transfert de badges, Historique des transactions.</li>
            <li>Interface Administrateur : Gestion des utilisateurs, Gestion des badges, Rapports et statistiques.</li>
            <li>Sauvegarde et Transfert : Sauvegarde des données, Envoi dématérialisé.</li>
            <li>Technologies : NFC et RFID, Lecteur ACR.</li>
        </ul>

        <h3>4. Estimation des Coûts</h3>
        <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Développement Frontend (ReactJS)</td>
                        <td>1</td>
                        <td>1.500.000</td>
                        <td>1.500.000</td>
                    </tr>
                    <tr>
                        <td>Développement Backend (Laravel)</td>
                        <td>1</td>
                        <td>2.500.000</td>
                        <td>2.500.000</td>
                    </tr>
                    <tr>
                        <td>Intégration des Technologies NFC/RFID</td>
                        <td>1</td>
                        <td>1.800.000</td>
                        <td>1.800.000</td>
                    </tr>
                    <tr>
                        <td>Tests et Déploiement</td>
                        <td>1</td>
                        <td>800.000</td>
                        <td>800.000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Estimé</th>
                        <th>6.600.000 FCFA</th>
                    </tr>
                </tfoot>
            </table>
    </section>

    <footer>
        <p>Ce devis est valide jusqu'au 30 septembre 2024</p>
        <p>Pour toute question ou clarification, veuillez nous contacter.</p>
    </footer>
</body>
</html>
