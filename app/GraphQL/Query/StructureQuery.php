<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Structure;
class StructureQuery extends Query
{
    protected $attributes = [
        'name' => 'structures'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Structure'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Structure::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Structure $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom_structure'           => $item->nom_structure
            ];
        });

    }
}
