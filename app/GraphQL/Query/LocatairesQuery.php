<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Locataire,Outil};
class LocatairesQuery extends Query
{
    protected $attributes = [
        'name' => 'locataires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Locataire'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'code'                => ['type' => Type::string()],
            'nom'                 => ['type' => Type::string()],
            'prenom'              => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Locataire::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
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
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Locataire $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'nom'                     => $item->nom,
                'prenom'                  => $item->prenom,
                'telephone'               => $item->telephone,
                'CNI'                     => $item->CNI,
                'proprietaire_id'         => $item->proprietaire_id,
                'proprietaire'            => $item->proprietaire,
            ];
        });

    }
}
