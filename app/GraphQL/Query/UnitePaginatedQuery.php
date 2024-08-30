<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{Unite};

class UnitePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'unitespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('unitespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'bien_immo_id'                  => ['type' => Type::int()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = Unite::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        // if (isset($args['locataire_id']))
        // {
        //     $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['code'].'%');
        // }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'asc')->paginate($count, ['*'], 'page', $page);
    }
}

