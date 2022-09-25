<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{BienImmo,Outil};

class BienImmoPaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'bienimmospaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('bienimmospaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'code'                          => ['type' => Type::string()],
            'desc'                          => ['type' => Type::string()], 
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = BienImmo::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['code']))
        {
            $query->where('code',$args['code']);
        }
        if (isset($args['desc']))
        {
            $query = $query->where('desc',Outil::getOperateurLikeDB(),'%'.$args['desc'].'%');
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}

