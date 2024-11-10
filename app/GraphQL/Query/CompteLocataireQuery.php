<?php

namespace App\GraphQL\Query;

use  App\Models\{CompteLocataire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        $query = CompteLocataire::with('locataire');

        // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
        if ($user && $user->structure_id) {
            $query->whereHas('locataire.user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
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
        $query->whereHas('detail_journal', function ($q) {
            $q->where('annule', false);
        });
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
