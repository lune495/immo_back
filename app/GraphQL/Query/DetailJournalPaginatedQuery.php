<?php

namespace App\GraphQL\Query;

use App\Models\{Outil,DetailJournal};
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DetailJournalPaginatedQuery extends Query
{
    protected $attributes =
    [
        'name' => 'detailjournalspaginated'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('DetailJournal'));
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
            'locataire_id'             => ['type' => Type::int()],
            'journal_id'               => ['type' => Type::int()],

            'page'                     => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                    => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }

    public function resolve($root, $args)
    {
        $query = DetailJournal::with('journal');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['locataire_id']))
        {
            $query->where('locataire_id', $args['locataire_id']);
        }
        if (isset($args['journal_id']))
        {
            $query->where('journal_id', $args['journal_id']);
        }

        $query->orderBy('locataire_id','asc');
        $count = Arr::get($args, 'count', 20);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);

    }
}
