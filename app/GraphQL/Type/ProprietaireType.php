<?php

namespace App\GraphQL\Type;

use  App\Models\{Proprietaire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class ProprietaireType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'Proprietaire',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => ['type' => Type::int(), 'description' => ''],
            'code'                              => ['type' => Type::string()],
            'nom'                               => ['type' => Type::string()],
            'prenom'                            => ['type' => Type::string()],
            'telephone'                         => ['type' => Type::string()],
            'agence_id'                         => ['type' => Type::int()],
            'agence'                            => ['type' => GraphQL::type('Agence')],
            'bien_immos'                        => ['type' => Type::listOf(GraphQL::type('BienImmo')), 'description' => ''],
            'nbr_bien'                          => ['type' => Type::int()],

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

    protected function resolveNbrBienField($root, $args)
    {
        $proprio = Proprietaire::with('bien_immos')->find($root['id']);
        return count($proprio->bien_immos);
    }
    
}
