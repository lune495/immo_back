<?php

namespace App\GraphQL\Query;

use  App\Models\{NatureLocal};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class NatureLocalQuery extends Query
{
    protected $attributes = [
        'name' => 'nature_locations'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('NatureLocal'));
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
        $query = NatureLocal::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (NatureLocal $item)
        {
            return
            [
                'id'                                => $item->id,
                'nom'                               => $item->nom,
            ];
        });
    }
}
