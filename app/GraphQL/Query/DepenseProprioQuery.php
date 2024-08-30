<?php

namespace App\GraphQL\Query;

use  App\Models\{DepenseProprio};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DepenseProprioQuery extends Query
{
    protected $attributes = [
        'name' => 'depense_proprios'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('DepenseProprio'));
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
        $query = DepenseProprio::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (DepenseProprio $item)
        {
            return
            [
                'id'                                => $item->id,
                'libelle'                           => $item->libelle,
                //'deleted_at'                        => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),
            ];
        });
    }
}
