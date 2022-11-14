<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\{Locataire,Outil};
class LocatairesQuery extends Query
{
    protected $attributes = [
        'name' => 'locataires'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Locataire'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'code'                => ['type' => Type::string()],
            'nom'                 => ['type' => Type::string()],
            'prenom'              => ['type' => Type::string()],
            'search'              => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Locataire::query();
        if (isset($args['id']))
        {
            $query = $query->where('id', $args['id']);
        }
        if (isset($args['search']))
        {
            $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['search'].'%')
            ->orWhere('nom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%')
            ->orWhere('prenom', Outil::getOperateurLikeDB(),'%'. $args['search'] . '%');
        }
        if (isset($args['nom']))
        {
            $query = $query->where('nom',Outil::getOperateurLikeDB(),'%'.$args['nom'].'%');
        }
        if (isset($args['prenom']))
        {
            $query = $query->where('prenom',Outil::getOperateurLikeDB(),'%'.$args['prenom'].'%');
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Locataire $item)
        {
            return
            [
                'id'                      => $item->id,
                'code'                    => $item->code,
                'nom'                     => $item->nom,
                'prenom'                  => $item->prenom,
                'cc'                      => $item->cc,
                'telephone'               => $item->telephone,
                'montant_loyer'           => $item->montant_loyer,
                'montant_loyer_ttc'       => $item->montant_loyer_ttc,
                'montant_loyer_ht'        => $item->montant_loyer_ht,
                'descriptif_loyer'        => $item->descriptif_loyer,
                'CNI'                     => $item->CNI,
                'bien_immo_id'            => $item->bien_immo_id,
                'bien_immo'               => $item->bien_immo,
                'locataire_taxes'         => $item->locataire_taxes,
            ];
        });

    }
}
