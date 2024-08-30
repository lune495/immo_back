<?php

namespace App\GraphQL\Query;
use App\Models\{Agence};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;


class AgencePaginatedQuery extends Query
{
    protected $attributes = [
        'name' => 'agencespaginated',
        'description' => ''
    ];

    public function type():type
    {
        return GraphQL::type('agencespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Agence::with('proprietaires');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $count = Arr::get($args, 'count', 20);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);

    }
}

