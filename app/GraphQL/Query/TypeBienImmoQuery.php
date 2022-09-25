<?php

namespace App\GraphQL\Query;

use App\Models\{TypeBienImmo};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TypeBienImmoQuery extends Query
{
    protected $attributes = [
        'name' => 'type_bien_immos'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('TypeBienImmo'));
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
        $query = TypeBienImmo::with('bien_immos');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (TypeBienImmo $item)
        {
            return
            [
                'id'                                => $item->id,
                'nom'                               => $item->nom
                //'deleted_at'                        => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),
            ];
        });
    }
}
