<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{Locataire,Outil};

class LocatairePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'locatairespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('locatairespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'nom'                           => ['type' => Type::string()],
            'prenom'                        => ['type' => Type::string()],
            'code'                          => ['type' => Type::string()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = Locataire::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['code']))
        {
            $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['code'].'%');
        }
        if (isset($args['nom']))
        {
            $query = $query->where('nom',Outil::getOperateurLikeDB(),'%'.$args['nom'].'%');
        }
        if (isset($args['prenom']))
        {
            $query = $query->where('prenom',Outil::getOperateurLikeDB(),'%'.$args['prenom'].'%');
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'asc')->paginate($count, ['*'], 'page', $page);
    }
}

