<?php

namespace App\GraphQL\Type;

use  App\Models\{Assujetissement};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Facades\DB;

class AssujetissementType extends GraphQLType
{
    protected $attributes =
    [
        'name' => 'Assujetissement',
        'description' => ''
    ];

    public function fields():array
    {
        return
        [
            'id'                                => ['type' => Type::int(), 'description' => ''],
            'libelle'                           => ['type' => Type::string()],
        ];
    }
    
}
