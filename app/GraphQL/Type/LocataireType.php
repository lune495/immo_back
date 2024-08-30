<?php

namespace App\GraphQL\Type;

use App\Models\{Locataire,CompteLocataire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class LocataireType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'Locataire',
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
            'cni'                               => ['type' => Type::string()],
            'adresse_profession'                => ['type' => Type::string()],
            'situation_matrimoniale'            => ['type' => Type::string()],
            'profession'                        => ['type' => Type::string()],
            'montant_loyer_ttc'                 => ['type' => Type::float()],
            'montant_loyer_ht'                  => ['type' => Type::float()],
            'descriptif_loyer'                  => ['type' => Type::string()],
            'url_qr_code'                       => ['type' => Type::string()],
            'bien_immo_id'                      => ['type' => Type::int()],
            'caution'                           => ['type' => Type::int()],
            'multipli'                          => ['type' => Type::int()],
            'resilier'                          => ['type' => Type::boolean()],
            'unite'                             => ['type' => GraphQL::type('Unite')],
            'cc'                                => ['type' => Type::int()],
            'locataire_taxes'                   => ['type' => Type::listOf(GraphQL::type('LocataireTaxe')), 'description' => ''],
            'bien_immo'                         => ['type' => GraphQL::type('BienImmo')],
            'en_regle'                          => ['type' => Type::int()],
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

    protected function resolveCautionField($root, $args){

        $multipli = is_array($root) ? $root['multipli'] : $root->multipli;
        $montant_loyer = is_array($root) ? $root['montant_loyer_ttc'] : $root->montant_loyer_ttc;
    
        return $multipli * round($montant_loyer);
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

    protected function resolveEnRegleField($root, $args)
    {
        $compte_locataires = CompteLocataire::where('locataire_id',$root['id'])->get();
        $total_debit = 0;
        $total_credit = 0;
        foreach ($compte_locataires as $compte_locataire) {
            $total_debit += $compte_locataire->debit;
            $total_credit += $compte_locataire->credit;
        }
        return $total_debit - $total_credit;
    }
}
