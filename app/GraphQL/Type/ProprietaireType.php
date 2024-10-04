<?php

namespace App\GraphQL\Type;

use  App\Models\{Proprietaire,Compte,Outil};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class ProprietaireType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'Proprietaire',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => ['type' => Type::int(), 'description' => ''],
            'code'                              => ['type' => Type::string()],
            'nom'                               => ['type' => Type::string()],
            'prenom'                            => ['type' => Type::string()],
            'telephone'                         => ['type' => Type::string()],
            'user'                              => ['type' => GraphQL::type('User')],
            'assujetissement_id'                => ['type' => Type::int()],
            'assujetissement'                   => ['type' => GraphQL::type('Assujetissement')],
            'bien_immos'                        => ['type' => Type::listOf(GraphQL::type('BienImmo')), 'description' => ''],
            'nbr_bien'                          => ['type' => Type::int()],
            'cgf'                               => ['type' => Type::string()],
            'foncier_bati'                      => ['type' => Type::string()],

        ];
    }

    /*************** Pour les dates ***************/
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

    protected function resolveNbrBienField($root, $args)
    {
        $proprio = Proprietaire::with('bien_immos')->find($root['id']);
        return count($proprio->bien_immos);
    }

    protected function resolveCgfField($root, $args)
    {
        // Récupérer l'année en cours
        $currentYear = date('Y');

        // Récupérer tous les comptes associés au propriétaire pour l'année en cours
        $comptes = Compte::where('proprietaire_id', $root['id'])
                        ->whereYear('created_at', $currentYear)
                        ->get();

        // Initialiser le revenu annuel
        $revenu_proprio_annuel = 0;

        // Calculer le revenu annuel total pour l'année en cours
        if ($comptes) {
            foreach ($comptes as $compte) {
                $revenu_proprio_annuel += $compte->montant_compte;
            }
        }

        // Calculer la CGF en fonction du revenu annuel
        $cgf = 0;

        if ($revenu_proprio_annuel <= 12000000) {
            // Revenu jusqu'à 12,000,000
            $cgf = $revenu_proprio_annuel / 12;
        } elseif ($revenu_proprio_annuel > 12000000 && $revenu_proprio_annuel <= 18000000) {
            // Revenu entre 12,000,001 et 18,000,000
            $cgf = $revenu_proprio_annuel * 1.5 / 12;
        } elseif ($revenu_proprio_annuel > 18000000) {
            // Revenu supérieur à 18,000,000
            $cgf = $revenu_proprio_annuel / 6;
        }

        // Retourner le montant de la CGF
       // Arrondir la valeur de la CGF pour éviter les erreurs de type
        return $cgf = Outil::formatPrixToMonetaire($cgf, true, true);
    }

    protected function resolveFoncierBatiField($root,$args){
        $currentYear = date('Y');

        // Récupérer tous les comptes associés au propriétaire pour l'année en cours
        $comptes = Compte::where('proprietaire_id', $root['id'])
                        ->whereYear('created_at', $currentYear)
                        ->get();

        // Initialiser le revenu annuel
        $revenu_proprio_annuel = 0;

        // Calculer le revenu annuel total pour l'année en cours
        if ($comptes) {
            foreach ($comptes as $compte) {
                $revenu_proprio_annuel += $compte->montant_compte;
            }
        }

        return Outil::formatPrixToMonetaire(Outil::formatPrixToMonetaire(($revenu_proprio_annuel * 0.005),true,true));
    }
}