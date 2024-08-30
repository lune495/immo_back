<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Proprietaire,Outil};
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
        $query = Proprietaire::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['search']))
        {
            $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['search'].'%')
            ->orWhere('nom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%')
            ->orWhere('prenom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%');;
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
                'agence_id'               => $item->agence_id,
                'agence'                  => $item->agence,
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
