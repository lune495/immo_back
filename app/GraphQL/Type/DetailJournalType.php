<?php

namespace App\GraphQL\Type;

use App\Models\{DetailJournal,Outil};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DetailJournalType extends GraphQLType
{

    protected $attributes =
    [
        'name' => 'DetailJournal',
        'description' => ''
    ];

    
    public function fields():array
    {
        return
        [
            'id'                                => ['type' => Type::int(), 'description' => ''],
            'code'                              => ['type' => Type::string()],
            'libelle'                           => ['type' => Type::string()],
            'entree'                            => ['type' => Type::int()],
            'sortie'                            => ['type' => Type::int()],
            'solde'                             => ['type' => Type::int()],
            'locataire_id'                      => ['type' => Type::int()],
            'locataire'                         => ['type' => GraphQL::type('Locataire')],
            'user_id'                           => ['type' => Type::int()],
            'user'                              => ['type' => GraphQL::type('User')],
            'proprietaire_id'                   => ['type' => Type::int()],
            'proprietaire'                      => ['type' => GraphQL::type('Proprietaire')],
            'journal_id'                        => ['type' => Type::int()],
            'annule'                            => ['type' => Type::boolean()],
            'journal'                           => ['type' => GraphQL::type('Journal')],
            'created_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'created_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
            'updated_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'updated_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
        ];
    }

    public function resolveLibelleField($root, $args)
    {
        if (isset($root['locataire']) && isset($root['locataire']['prenom'])) {
            $paiement = "Paiement de " . $root['locataire']['prenom']." ".$root['locataire']['nom'];
            return Outil::toutEnMajuscule($paiement);
        } elseif (isset($root['proprietaire']) && isset($root['proprietaire']['prenom'])) {
            $depense = "Depense du bailleur " . $root['proprietaire']['prenom']." ".$root['proprietaire']['nom'];
            return Outil::toutEnMajuscule($depense);
        }    
    }

    // /*************** Pour les dates ***************/
    protected function resolveCreatedAtField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $date_at = $root->created_at;
        }
        else
        {
            $date_at = is_string($root['created_at']) ? $root['created_at'] : $root['created_at']->format(Outil::formatdate());
        }
        return $date_at;
    }
    protected function resolveCreatedAtFrField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $created_at = $root->created_at;
        }
        else
        {
            $created_at = $root['created_at'];
        }
        return Carbon::parse($created_at)->format('d/m/Y H:i:s');
    }
    protected function resolveUpdatedAtField($root, $args)
    {
        if (!isset($root['updated_at']))
        {
            $date_at = $root->updated_at;
        }
        else
        {
            $date_at = is_string($root['updated_at']) ? $root['updated_at'] : $root['updated_at']->format(Outil::formatdate());
        }
        return $date_at;
    }   

    protected function resolveUpdatedAtFrField($root, $args)
    {
        if (!isset($root['created_at']))
        {
            $date_at = $root->created_at;
        }
        else
        {
            $date_at = $root['created_at'];
        }
        return Carbon::parse($date_at)->format('d/m/Y H:i:s');
    }

    protected function resolveSoldeField($root, $args)
    {
        $solde = $root['entree'] - $root['sortie'];
        return $solde;
    }
    
}



