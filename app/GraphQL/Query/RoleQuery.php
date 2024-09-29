<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use App\Models\Role;
class RoleQuery extends Query
{
    protected $attributes = [
        'name' => 'roles'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Role'));
    }

    public function args(): array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'nom'                 => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Role::query();
        $query->orderBy('id', 'desc');
        $query = $query->get();
        return $query->map(function (Role $item)
        {
            return
            [
                'id'                      => $item->id,
                'nom'                     => $item->roles
            ];
        });

    }
}
