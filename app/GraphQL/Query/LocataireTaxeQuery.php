<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{LocataireTaxe,Outil};
class LocataireTaxeQuery extends Query
{
    protected $attributes = [
        'name' => 'locataire_taxes'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('LocataireTaxe'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = LocataireTaxe::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (LocataireTaxe $item)
        {
            return
            [
                'id'                      => $item->id,
                'locataire_id'            => $item->locataire_id,
                'locataire'               => $item->locataire,
                'taxe_id'                 => $item->taxe_id,
                'taxe'                    => $item->taxe
            ];
        });

    }
}
