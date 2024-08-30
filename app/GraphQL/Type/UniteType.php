<?php

namespace App\GraphQL\Type;

use  App\Models\{Unite};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class UniteType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'Unite',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                         => ['type' => Type::int(), 'description' => ''],
            'bien_immo'                  => ['type' => GraphQL::type('BienImmo')],
            'nature_local'               => ['type' => GraphQL::type('NatureLocal')],
            'etage'                      => ['type' => Type::int(), 'description' => ''],
            'superficie_en_m2'           => ['type' => Type::int(), 'description' => ''],
            'annee_achevement'           => ['type' => Type::string(), 'description' => ''],
            'nombre_piece_principale'    => ['type' => Type::int(), 'description' => ''],
            'nombre_salle_de_bain'       => ['type' => Type::int(), 'description' => ''],
            'locataires'                 => ['type' => Type::listOf(GraphQL::type('Locataire')), 'description' => ''],
            'montant_loyer'              => ['type' => Type::int()],
            'type_localisation'          => ['type' => Type::string()],
            'numero'                     => ['type' => Type::string()],
            'locataire'                  => ['type' => GraphQL::type('Locataire')],
            'balcon'                     => ['type' => Type::boolean(), 'description' => ''],
            'dispo'                      => ['type' => Type::boolean(), 'description' => ''],
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
    
}
