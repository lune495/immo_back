<?php

namespace App\GraphQL\Type;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Locataire,Outil,Proprietaire};
use Carbon\Carbon;



class DashboardType extends GraphQLType
{

    protected $attributes = [
        'name' => 'Dashboard',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            
            'nb_locataire_actif'         => ['type' => Type::int(), 'description' => ''],
            'nb_locataire_retard'        => ['type' => Type::int(), 'description' => ''],
            'nb_locataire_nouveau_mois'  => ['type' => Type::int(), 'description' => ''],
            'nb_bailleur_deficite'       => ['type' => Type::int(), 'description' => ''],
            // 'nb_vente_mois'              => ['type' => Type::int(), 'description' => ''],
            // 'nb_vente_annee'             => ['type' => Type::int(), 'description' => ''],

            // 'nbproduitjour'              => ['type' => Type::int(), 'description' => ''],
            // 'nbproduitmois'              => ['type' => Type::int(), 'description' => ''],
            // 'nbproduitannee'             => ['type' => Type::int(), 'description' => ''],
            // 'Caproduit'                  => ['type' => Type::string(), 'description' => ''],

            // 'nbdepensejour'              => ['type' => Type::int(), 'description' => ''],
            // 'nbdepensemois'              => ['type' => Type::int(), 'description' => ''],
            // 'nbdepenseannee'             => ['type' => Type::int(), 'description' => ''],

            // 'Caventejour'              => ['type' => Type::string(), 'description' => ''],
            // 'Caventemois'              => ['type' => Type::string(), 'description' => ''],
            // 'Caventeannee'             => ['type' => Type::string(), 'description' => ''],
            // 'Cajour'                   => ['type' => Type::string(), 'description' => ''],
            // 'Cahier'                   => ['type' => Type::string(), 'description' => ''],
            // 'capital'                  => ['type' => Type::int()],
            // 'Camois'                   => ['type' => Type::string(), 'description' => ''],
            // 'Camoisdernier'            => ['type' => Type::string(), 'description' => ''],
        
            // 'meilleurs_clients'             => ['type' => Type::string(), 'description' => ''],

        ];
    }
    // protected function resolveMeilleursClientsField($root, $args)
    // { 
    //     $retour =  Outil::donneMeilleursClients();
    //     return $retour;
    // }

    // protected function resolveCapitalField($root, array $args)
    // {
    //     $produits = Produit::all();
    //     $capital = 0;
    //     foreach ($produits as $produit)
    //     {
    //         $capital = $capital + ($produit->pa * $produit->qte);
    //     }
    //     return $capital;
    // }

    // protected function resolveCajourField($root, $args)
    // {
    //     $today = date('Y-m-d');
    //     $debut = date($today.' 00:00:00');
    //     $fin = date($today.' 23:59:59');
    //     $Caventejour = Outil::getCavente($debut,  $fin );
    //     return $Caventejour;
    // }
    // protected function resolveCahierField($root, $args)
    // {
    //     //$today = date('Y-m-d');
    //     $yesterday = Carbon::yesterday()->toDateString(); 
    //     $debut = date($yesterday.' 00:00:00');
    //     $fin = date($yesterday.' 23:59:59');
    //     //dd($debut,$fin);
    //     $Caventehier = Outil::getCavente($debut,  $fin );
    //     return $Caventehier;
    // }
    // protected function resolveCamoisField($root, $args)
    // {
    //     //$today = date('Y-m-d');
    //     $debut = Carbon::now()->startOfMonth()->toDateString();
    //     $fin = Carbon::now();
    //     $Camois = Outil::getCavente($debut,  $fin );
    //     return $Camois;
    // }

    // protected function resolveCamoisdernierField($root, $args)
    // {
    //     $debut = Carbon::now()->startOfMonth()->subMonth()->toDateString();
    //     $fin = date('Y-m-d');
    //     $Camoisdernier = Outil::getCavente($debut,  $fin );
    //     return $Camoisdernier;
    // }
   
}