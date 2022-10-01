<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Bien,Outil};
class BienQuery extends Query
{
    protected $attributes = [
        'name' => 'biens'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Bien'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'code'                => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Bien::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['code']))
        {
            $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['code'].'%');
        }
        
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Bien $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'description'             => $item->description,
                'adresse'                 => $item->adresse,
                'type_bien_immo_id'       => $item->type_bien_immo_id,
                'type_bien_immo'          => $item->type_bien_immo,
                'proprietaire_id'         => $item->proprietaire_id,
                'proprietaire'            => $item->proprietaire,
                'bien_immos'              => $item->bien_immos,
            ];
        });

    }
}
