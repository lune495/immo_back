<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{NotifEcheanceContrat,Outil};
use Illuminate\Support\Facades\Auth;
class NotifEcheanceContratQuery extends Query
{
    protected $attributes = [
        'name' => 'notif_echeance_contrats'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('NotifEcheanceContrat'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'locataire_id'        => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = NotifEcheanceContrat::query();

         // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
         if ($user && $user->structure_id) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['locataire_id']))
        {
            $query = $query->where('locataire_id', $args['locataire_id']);
        }
        
        $query->orderBy('id', 'asc');
        $query = $query->get();
        return $query->map(function (NotifEcheanceContrat $item)
        {
            return
            [
                'id'                      => $item->id,
                'locataire'               => $item->locataire,
                'user'                    => $item->user,
                'lu'                      => $item->lu,
                'date_echeance_contrat'   => $item->date_echeance_contrat,
            ];
        });
    }
}