<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{BienImmo,Outil};
use Illuminate\Support\Facades\Auth;
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
            'proprietaire_id'     => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = BienImmo::with('locataires','unites');

         // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
         if ($user && $user->structure_id) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['proprietaire_id']))
        {
            $query = $query->where('proprietaire_id', $args['proprietaire_id']);
        }
        if (isset($args['desc']))
        {
            $query = $query->where('desc',Outil::getOperateurLikeDB(),'%'.$args['desc'].'%');
        }
        
        $query->orderBy('id', 'asc');
        $query = $query->get();
        return $query->map(function (BienImmo $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'unites'                  => $item->unites,
                'adresse'                 => $item->adresse,
                'nom_immeuble'            => $item->nom_immeuble,
                'description'             => $item->description,
                'nbr_etage'               => $item->nbr_etage,
                'nbr_total_appartement'   => $item->nbr_total_appartement,
                'nbr_magasin'             => $item->nbr_magasin,
                'locataires'              => $item->locataires,
                'proprietaire_id'         => $item->proprietaire_id,
                'proprietaire'            => $item->proprietaire,
                'nbr_dispo'               => $item->nbr_dispo
            ];
        });
    }
}