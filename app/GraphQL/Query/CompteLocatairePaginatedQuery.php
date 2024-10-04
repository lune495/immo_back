<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{CompteLocataire,Outil};
use Illuminate\Support\Facades\Auth;

class CompteLocatairePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'comptelocatairespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('comptelocatairespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'locataire_id'                  => ['type' => Type::int()],
            'locataire_id'                  => ['type' => Type::int()],
            'quittance'                     => ['type' => Type::boolean()],
            'nom'                           => ['type' => Type::string()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = CompteLocataire::with('locataire');

        // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
        if ($user && $user->structure_id) {
            $query->whereHas('locataire.user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['quittance']))
        {
            $query->where('credit', '>', 0);
        }
        if (isset($args['locataire_id']))
        {
            $query = $query->where('locataire_id', $args['locataire_id']);
        }
        if (isset($args['nom'])) {
            $query->whereHas('locataire', function($q) use ($args) {
                $q->where('nom', 'like', '%' . $args['nom'] . '%');
            });
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}

