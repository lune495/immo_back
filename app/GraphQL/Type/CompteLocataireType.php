<?php

namespace App\GraphQL\Type;

use App\Models\{CompteLocataire,LocataireTaxe};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class CompteLocataireType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'CompteLocataire',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => [ 'type' => Type::int(), 'description' => ''],
            'dernier_date_paiement'             => ['type'  => Type::string()],
            'debit'                             => ['type'  => Type::int()],
            'credit'                            => ['type'  => Type::int()],
            'credit_ttc'                        => ['type'  => Type::int()],
            'montan'                            => ['type'  => Type::int()],
            'statut_paye'                       => ['type'  => Type::boolean()],
            'locataire_id'                      => ['type'  => Type::int()],
            'locataire'                         => ['type'  => GraphQL::type('Locataire')],
            'locataire_id'                      => ['type'  => Type::int()],
            'created_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'created_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
            'updated_at'                        => [ 'type' => Type::string(), 'description' => ''],
            'updated_at_fr'                     => [ 'type' => Type::string(), 'description' => ''],
        ];
    }



    protected function resolveCreditTtcField($root, $args)
    {
        $taxe = 0;
        $loyer_ttc = 0;
        $locataire_taxes = LocataireTaxe::where('locataire_id',$root['locataire_id'])->get();
        foreach ($locataire_taxes as $locataire_taxe) {
            $taxe += $locataire_taxe->value/100;
        }
        $somme_tva = 1 + $taxe;
        $loyer_ttc = $root['credit'] * $somme_tva;
        return $loyer_ttc;
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
    
}
