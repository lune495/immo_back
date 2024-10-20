<?php

namespace App\GraphQL\Query;

use  App\Models\{NatureLocal};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $query = NatureLocal::query();
        // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
        if ($user && $user->structure_id) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
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
