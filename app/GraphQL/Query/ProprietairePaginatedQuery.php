<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use \App\Models\{Proprietaire,Outil};
use Illuminate\Support\Facades\Auth;

class ProprietairePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'proprietairespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('proprietairespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'nom'                           => ['type' => Type::string()],
            'prenom'                        => ['type' => Type::string()],
            'code'                          => ['type' => Type::string()],
            'search'                        => ['type' => Type::string()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = Proprietaire::query();
        // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
        if ($user && $user->structure_id) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }

        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['search'])) {
            $searchTerm = trim(strtolower($args['search'])); // Convertir en minuscule et enlever les espaces
            $query->where(function ($q) use ($searchTerm) {
                $q->where(DB::raw('LOWER(code)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('LOWER(nom)'), 'like', '%' . $searchTerm . '%')
                  ->orWhere(DB::raw('LOWER(prenom)'), 'like', '%' . $searchTerm . '%');
            });
        } else {
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
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'desc')->paginate($count, ['*'], 'page', $page);
    }
}

