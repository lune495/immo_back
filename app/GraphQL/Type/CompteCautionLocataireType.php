<?php

namespace App\GraphQL\Type;

use App\Models\{CompteCautionLocataire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class CompteCautionLocataireType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'CompteCautionLocataire',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => [ 'type' => Type::int(), 'description' => ''],
            'locataire_id'                      => ['type'  => Type::int()],
            'locataire'                         => ['type'  => GraphQL::type('Locataire')],
            'montant_compte'                    => ['type'  => Type::int()],
            'created_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'created_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
            'updated_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'updated_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
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
