<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentation de l'Application d'Agence Immobilière</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        nav {
            background-color: #34495e;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3 {
            color: #2c3e50;
        }
        .section {
            margin-bottom: 30px;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #34495e;
            color: #fff;
        }
        .highlight {
            background-color: #ecf0f1;
            padding: 15px;
            border-left: 5px solid #2c3e50;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Documentation de l'Application d'Agence Immobilière</h1>
    </header>
    <nav>
        <a href="#introduction">Introduction</a>
        <a href="#fonctionnalites">Fonctionnalités</a>
        <a href="#technologies">Technologies</a>
        <a href="#securite">Sécurité</a>
        <a href="#deploiement">Déploiement</a>
        <a href="#conclusion">Conclusion</a>
    </nav>
    <div class="container">
        <section id="introduction" class="section">
            <h2>Introduction</h2>
            <p>L'application d'agence immobilière est conçue pour faciliter la gestion des biens immobiliers, des locataires, et des bailleurs. Elle offre une plateforme centralisée pour la gestion des transactions financières et des relations locatives, améliorant ainsi l'efficacité et la transparence pour les agences immobilières.</p>
            <div class="highlight">
                <p><strong>Valeur ajoutée :</strong> Cette application permet aux agences immobilières de gérer efficacement leurs propriétés, de suivre les transactions financières avec précision, et de générer des rapports détaillés pour les locataires et les bailleurs.</p>
            </div>
        </section>

        <section id="fonctionnalites" class="section">
            <h2>Fonctionnalités Principales</h2>
            
            <h3>1. Comptabilité</h3>
            <p>La section Comptabilité permet d'enregistrer un journal des entrées et sorties financières.</p>
            <ul>
                <li><strong>Entrées :</strong> Enregistrement des montants des loyers payés par les locataires.</li>
                <li><strong>Sorties :</strong> Enregistrement des dépenses des bailleurs.</li>
            </ul>
            <p><em>Avantages :</em> Suivi précis des flux financiers, réduction des erreurs de comptabilité, transparence pour les bailleurs.</p>
            
            <h3>2. Gestion des Locataires</h3>
            <p>Cette fonctionnalité permet de lister, créer, mettre à jour, et supprimer des locataires.</p>
            <ul>
                <li><strong>CRUD complet :</strong> Gestion simplifiée des locataires avec un système CRUD intuitif.</li>
            </ul>
            <p><em>Avantages :</em> Centralisation des informations des locataires, gestion efficace des relations locatives.</p>

            <h3>3. Gestion des Bailleurs</h3>
            <p>La section Bailleur permet de lister les bailleurs et d'afficher leurs informations détaillées, y compris les biens immobiliers et les locataires associés.</p>
            <ul>
                <li><strong>Bouton d'information :</strong> Affichage des détails du bailleur, des biens immobiliers liés, et des locataires associés.</li>
            </ul>
            <p><em>Avantages :</em> Vue d'ensemble des biens sous gestion, simplification de la communication avec les bailleurs.</p>

            <h3>4. Situation des Locataires</h3>
            <p>Permet de générer un rapport PDF résumant toutes les transactions d'un locataire depuis son entrée.</p>
            <ul>
                <li><strong>Rapport détaillé :</strong> Résumé des débits, crédits, et solde évolutif sous forme de tableau.</li>
            </ul>
            <p><em>Avantages :</em> Transparence avec les locataires, facilité de résolution des litiges.</p>

            <h3>5. Situation des Bailleurs</h3>
            <p>Permet de générer un rapport PDF détaillant les recettes et dépenses liées à un bailleur.</p>
            <ul>
                <li><strong>Rapport financier :</strong> Résumé complet des transactions financières pour chaque bailleur.</li>
            </ul>
            <p><em>Avantages :</em> Clarté dans la gestion des finances des bailleurs, rapports faciles à partager.</p>

            <h3>6. Gestion des Biens Immobiliers</h3>
            <p>Cette section permet de lister les biens immobiliers, avec l'option d'afficher les détails des locaux disponibles et des locataires associés via une fenêtre modale.</p>
            <ul>
                <li><strong>Détails des biens :</strong> Affichage des informations des locaux disponibles et des locataires en place.</li>
            </ul>
            <p><em>Avantages :</em> Gestion simplifiée des biens, allocation efficace des ressources, suivi des locations.</p>
        </section>

        <section id="technologies" class="section">
            <h2>Technologies Utilisées</h2>
            <p>L'application est construite avec des technologies modernes pour assurer robustesse et évolutivité.</p>
            <ul>
                <li><strong>Front-End :</strong> Utilisation de React pour une interface utilisateur réactive et dynamique.</li>
                <li><strong>Back-End :</strong> Laravel pour une gestion efficace des données et des processus métier.</li>
                <li><strong>Base de données :</strong> Postgres pour un stockage fiable et structuré des informations.</li>
            </ul>
        </section>

        <section id="securite" class="section">
            <h2>Sécurité</h2>
            <p>L'application intègre des mesures de sécurité pour protéger les données sensibles des utilisateurs.</p>
            <ul>
                <li><strong>Authentification et Autorisation :</strong> Système d'authentification robuste pour garantir que seules les personnes autorisées accèdent aux informations sensibles.</li>
                <li><strong>Sécurité des données :</strong> Chiffrement des données critiques et sauvegardes régulières pour éviter toute perte d'information.</li>
            </ul>
        </section>

        <section id="deploiement" class="section">
            <h2>Déploiement et Maintenance</h2>
            <p>Le déploiement de l'application est optimisé pour une installation simple sur un serveur de production.</p>
            <ul>
                <li><strong>Déploiement :</strong> Guide détaillé pour installer et configurer l'application sur un serveur Ubuntu.</li>
                <li><strong>Maintenance :</strong> Recommandations pour les mises à jour et la sauvegarde régulière de la base de données.</li>
            </ul>
        </section>

        <section id="conclusion" class="section">
            <h2>Conclusion</h2>
            <p>Cette application d'agence immobilière apporte une valeur significative en améliorant la gestion des biens, la relation avec les locataires, et la transparence avec les bailleurs. Grâce à ses fonctionnalités complètes et son interface intuitive, elle constitue un outil essentiel pour toute agence cherchant à moderniser et optimiser ses opérations.</p>
            <p>Les prochaines étapes incluent l'intégration de nouvelles fonctionnalités pour répondre aux besoins évolutifs des utilisateurs et l'amélioration continue de l'expérience utilisateur.</p>
        </section>
    </div>
    <footer>
        <p>© 2024 Application d'Agence Immobilière. Tous droits réservés.</p>
    </footer>
</body>
</html>