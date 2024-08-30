<?php

namespace App\GraphQL\Query;

use  App\Models\{Agence};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AgencesQuery extends Query
{
    protected $attributes = [
        'name' => 'agences'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Agence'));
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
        $query = Agence::with('proprietaires');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (Agence $item)
        {
            return
            [
                'id'                                => $item->id,
                'nom_agence'                        => $item->nom_agence,
                'adresse'                           => $item->adresse,
                'num_fixe'                          => $item->num_fixe,
                //'deleted_at'                        => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),
            ];
        });
    }
}
