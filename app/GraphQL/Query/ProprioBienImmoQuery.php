<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{ProprioBienImmo,Outil};
class ProprioBienImmoQuery extends Query
{
    protected $attributes = [
        'name' => 'proprio_bien_immos'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('ProprioBienImmo'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'proprietaire_id'     => ['type' => Type::int()],
            'bien_immo_id'        => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = ProprioBienImmo::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['proprietaire_id']))
        {
            $query = $query->where('proprietaire_id',$args['proprietaire_id']);
        }
        if (isset($args['bien_immo_id']))
        {
            $query = $query->where('bien_immo_id',$args['bien_immo_id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (ProprioBienImmo $item)
        {
            return
            [
                'id'                      => $item->id,
                'proprietaire_id'         => $item->proprietaire_id,
                'proprietaire'            => $item->proprietaire,
                'bien_immo_id'            => $item->bien_immo_id,
                'bien_immo'               => $item->bien_immo,
            ];
        });

    }
}
