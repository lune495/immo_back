<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class AgencePaginatedType extends GraphQLType
{
    protected $attributes = [
        'name' => 'agencespaginated'
    ];

    public function fields():array
    {
        return
        [
            'metadata' =>
            [
                'type' => GraphQL::type('Metadata'),
                'resolve' => function ($root)
                {
                    return array_except($root->toArray(), ['data']);
                }
            ],
            'data' =>
            [
                'type' => Type::listOf(GraphQL::type('Agence')),
                'resolve' => function ($root)
                {
                    return $root;
                }
            ]
        ];
    }


}
