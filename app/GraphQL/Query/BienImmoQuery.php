<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{BienImmo,Outil};
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
        $query = BienImmo::with('locataires','unites');
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