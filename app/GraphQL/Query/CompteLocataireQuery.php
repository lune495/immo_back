<?php

namespace App\GraphQL\Query;

use  App\Models\{CompteLocataire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CompteLocataireQuery extends Query
{
    protected $attributes = [
        'name' => 'compte_locataires'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('CompteLocataire'));
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
            'locataire_id'             => ['type' => Type::int()],
            'nom'                      => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = CompteLocataire::with('locataire');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        if (isset($args['locataire_id']))
        {
            $query->where('locataire_id', $args['locataire_id']);
        }
        if (isset($args['nom'])) {
            $query->whereHas('locataire', function($q) use ($args) {
                $q->where('nom', 'like', '%' . $args['nom'] . '%');
            });
        }

        $query = $query->orderBy('id','asc');
        $query = $query->get();

        return $query->map(function (CompteLocataire $item)
        {
            return
            [
                'id'                                => $item->id,
                'locataire_id'                      => $item->locataire_id,
                'locataire'                         => $item->locataire,
                'dernier_date_paiement'             => $item->dernier_date_paiement,
                'credit'                            => $item->credit,
                'debit'                             => $item->debit,
                'statut_paye'                       => $item->statut_paye,
                //'deleted_at'                        => empty($item->deleted_at) ? $item->deleted_at : $item->deleted_at->format(Outil::formatdate()),
            ];
        });
    }
}
