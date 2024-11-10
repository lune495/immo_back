<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Proprietaire,Outil};
use Illuminate\Support\Facades\Auth;

class ProprietairesQuery extends Query
{
    protected $attributes = [
        'name' => 'proprietaires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Proprietaire'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'code'                => ['type' => Type::string()],
            'nom'                 => ['type' => Type::string()],
            'prenom'              => ['type' => Type::string()],
            'search'              => ['type' => Type::string()],
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
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['search']))
        {
            // $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['search'].'%')
            // ->orWhere('nom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%')
            // ->orWhere('prenom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%');

            $query->where(function ($q) use ($args) {
                $q->where('code', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%')
                  ->orWhere('nom', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%')
                  ->orWhere('prenom', Outil::getOperateurLikeDB(), '%' . $args['search'] . '%');
            });
        }
        $query->orderBy('id', 'asc');
        $query = $query->get();
        return $query->map(function (Proprietaire $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'nom'                     => $item->nom,
                'prenom'                  => $item->prenom,
                'telephone'               => $item->telephone,
                'user'                    => $item->user,
                'bien_immos'              => $item->bien_immos,
                'nbr_bien'                => $item->nbr_bien,
                'assujetissement_id'      => $item->assujetissement_id,
                'assujetissement'         => $item->assujetissement,
                'cgf'                     => $item->cgf,
                'foncier_bati'            => $item->foncier_bati,
            ];
        });

    }
}
