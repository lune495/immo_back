<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{BienImmo,Outil};
class BienImmoQuery extends Query
{
    protected $attributes = [
        'name' => 'bien_immos'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('BienImmo'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'desc'                => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = BienImmo::with('locataire')->wherenotnull('bien_id');
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['desc']))
        {
            $query = $query->where('desc',Outil::getOperateurLikeDB(),'%'.$args['desc'].'%');
        }
        
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (BienImmo $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'description'             => $item->description,
                'loyer'                   => $item->loyer,
                'locataire'               => $item->locataire,
                'bien'                    => $item->bien,
            ];
        });

    }
}
