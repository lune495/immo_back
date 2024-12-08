<?php

namespace App\GraphQL\Query;

use  App\Models\{Produit};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ProduitQuery extends Query
{
    protected $attributes = [
        'name' => 'produits'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Produit'));
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Produit::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (Produit $item)
        {
            return
            [
                'id'                                => $item->id,
                'designation'                       => $item->designation,
                'prix'                              => $item->prix,
                'qte'                               => $item->qte,
                'montant_total'                     => $item->montant_total,
            ];
        });
    }
}
