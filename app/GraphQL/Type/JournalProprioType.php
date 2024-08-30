<?php

namespace App\GraphQL\Type;

use App\Models\{DetailJournal};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class JournalProprioType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'JournalProprio',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => [ 'type' => Type::int(), 'description' => ''],
            'proprietaire_id'                   => [ 'type' => Type::int(), 'description' => ''],
            'locataire_id'                      => ['type' => Type::int()],
            'locataire'                         => ['type' => GraphQL::type('Locataire')],
            'libelle'                           => [ 'type' => Type::string()],
            'entree'                            => [ 'type' => Type::int()],
            'sortie'                            => [ 'type' => Type::int()],
            'solde'                             => [ 'type' => Type::int()],
            'date_location'                     => [ 'type' => Type::string()],
            'attente'                           => [ 'type' => Type::int()],
            'depense_proprio'                   => ['type' => GraphQL::type('DepenseProprio')],
            'depense_proprio_id'                => ['type' => Type::int()],
            'created_at'                        => ['type' => Type::string()],
        ];
    }

    /*************** Pour les dates ***************/
   
    protected function resolveSoldeField($root, $args)
    {
        if (!isset($root['id']))
        {
            $id = $root->id;
        }
        else
        {
            $id = $root['id'];
        }
        $journaldetails = DetailJournal::where('journal_id',$id)->get();
        $total_entree = 0;
        $total_sortie = 0;
        foreach ($journaldetails as $journaldetail) {
            $total_entree = $total_entree + $journaldetail->entree;
            $total_sortie = $total_sortie + $journaldetail->sortie;
        }
        $solde = $total_entree - $total_sortie;
        return $solde;
    }
}
