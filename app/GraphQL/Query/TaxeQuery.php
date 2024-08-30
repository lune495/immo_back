<?php

namespace App\GraphQL\Query;

use  App\Models\{Taxe};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TaxeQuery extends Query
{
    protected $attributes = [
        'name' => 'taxes'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Taxe'));
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
        $query = Taxe::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (Taxe $item)
        {
            return
            [
                'id'                                => $item->id,
                'nom'                               => $item->nom,
                'value'                             => $item->value,
                //'deleted_at'                        => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),
            ];
        });
    }
}
