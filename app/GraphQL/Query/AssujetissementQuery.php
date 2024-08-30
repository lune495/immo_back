<?php

namespace App\GraphQL\Query;

use  App\Models\{Assujetissement};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AssujetissementQuery extends Query
{
    protected $attributes = [
        'name' => 'assujetissement'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Assujetissement'));
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
        $query = Assujetissement::with('proprietaires');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (Assujetissement $item)
        {
            return
            [
                'id'                                => $item->id,
                'libelle'                           => $item->libelle
            ];
        });
    }
}
