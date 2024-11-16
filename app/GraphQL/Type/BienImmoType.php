<?php

namespace App\GraphQL\Type;

use  App\Models\{BienImmo,Outil,Unite};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class BienImmoType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'BienImmo',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => ['type' => Type::int(), 'description' => ''],
            'code'                              => ['type' => Type::string()],
            'adresse'                           => ['type' => Type::string()],
            'nom_immeuble'                      => ['type' => Type::string()],
            'description'                       => ['type' => Type::string()],
            'nbr_etage'                         => ['type' => Type::int()],
            'nbr_total_appartement'             => ['type' => Type::int()],
            'nbr_magasin'                       => ['type' => Type::int()],
            'locataires'                        => ['type' => Type::listOf(GraphQL::type('Locataire'))],
            'unites'                            => ['type' => Type::listOf(GraphQL::type('Unite'))],
            'proprietaire_id'                   => ['type' => Type::int()],
            'nbr_dispo'                         => ['type' => Type::int()],
            'commission_agence'                 => ['type' => Type::float()],
            'proprietaire'                      => ['type' => GraphQL::type('Proprietaire')]

        ];
    }

    /*************** Pour les dates ***************/
    protected function resolveCreatedAtField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $date_at = $root->created_at;
        }
        else
        {
            $date_at = is_string($root['created_at']) ? $root['created_at'] : $root['created_at']->format(Outil::formatdate());
        }
        return $date_at;
    }
    protected function resolveCreatedAtFrField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $created_at = $root->created_at;
        }
        else
        {
            $created_at = $root['created_at'];
        }
        return Carbon::parse($created_at)->format('d/m/Y H:i:s');
    }

    public function resolveNbrDispoField($root, $args)
    {
        // return $root->unites->where('dispo', false)->count();
        // Vérifiez que $root est un objet BienImmo ou qu'il a un ID valide
        if (isset($root->id)) {
            // Parcourir toutes les unités et compter celles qui sont disponibles
            $nbr_dispo = Unite::where('bien_immo_id', $root->id)->where('dispo', false)->count();
            return $nbr_dispo;
        }

        return 0;
    }

    protected function resolveUpdatedAtField($root, $args)
    {
        if (!isset($root['updated_at']))
        {
            $date_at = $root->updated_at;
        }
        else
        {
            $date_at = is_string($root['updated_at']) ? $root['updated_at'] : $root['updated_at']->format(Outil::formatdate());
        }
        return $date_at;
    }   

    protected function resolveUpdatedAtFrField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $date_at = $root->created_at;
        }
        else
        {
            $date_at = $root['created_at'];
        }
        return Carbon::parse($date_at)->format('d/m/Y H:i:s');
    }

    protected function resolveLoyerField($root, $args)
    {
        if (!isset($root['loyer']))
        {
            $loyer = $root->loyer;
        }
        else
        {
            $loyer = $root['loyer'];
        }
        return Outil::formatPrixToMonetaire($loyer, false, false);
    }
    
}
