<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{ProprioBienImmo,Outil};

class ProprioBienImmoPaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'proprio_bien_immospaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('proprio_bien_immospaginated');
    }

    public function args():array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'proprietaire_id'     => ['type' => Type::int()],
            'bien_immo_id'        => ['type' => Type::int()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = ProprioBienImmo::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['proprietaire_id']))
        {
            $query = $query->where('proprietaire_id',$args['proprietaire_id']);
        }
        if (isset($args['bien_immo_id']))
        {
            $query = $query->where('bien_immo_id',$args['bien_immo_id']);
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}

