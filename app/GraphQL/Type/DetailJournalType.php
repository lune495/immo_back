<?php

namespace App\GraphQL\Type;

use App\Models\{DetailJournal};
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
            'libelle'                           => ['type' => Type::string()],
            'entree'                            => ['type' => Type::int()],
            'sortie'                            => ['type' => Type::int()],
            'locataire_id'                      => ['type' => Type::int()],
            'locataire'                         => ['type' => GraphQL::type('Locataire')],
            'journal_id'                        => ['type' => Type::int()],
            'journal'                           => ['type' => GraphQL::type('Journal')],
        ];
    }
    
}



