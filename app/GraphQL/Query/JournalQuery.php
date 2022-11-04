<?php

namespace App\GraphQL\Query;

use  App\Models\{Journal};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class JournalQuery extends Query
{
    protected $attributes = [
        'name' => 'journals'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Journal'));
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
        $query = Journal::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query = $query->get();

        return $query->map(function (Journal $item)
        {
            return
            [
                'id'                                => $item->id,
                'libelle'                           => $item->libelle,
                'entree'                            => $item->entree,
                'sortie'                            => $item->sortie,
                'solde'                             => $item->solde,
                'locataire_id'                      => $item->locataire_id,
                'locataire'                         => $item->locataire,
            ];
        });
    }
}
