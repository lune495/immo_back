<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{Produit,Outil};

class ProduitPaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'produitspaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('produitspaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'designation'                   => ['type' => Type::string()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = Produit::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['designation']))
        {
            $query = $query->where('designation',Outil::getOperateurLikeDB(),'%'.$args['designation'].'%');
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'asc')->paginate($count, ['*'], 'page', $page);
    }
}