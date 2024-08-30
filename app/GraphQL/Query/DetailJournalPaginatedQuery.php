<?php

namespace App\GraphQL\Query;

use App\Models\{Outil,DetailJournal};
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;

class DetailJournalPaginatedQuery extends Query
{
    protected $attributes =
    [
        'name' => 'detailjournalspaginated'
    ];

    public function type():type
    {
        return GraphQL::type('DetailJournalPaginated');
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
            'locataire_id'             => ['type' => Type::int()],
            'journal_id'               => ['type' => Type::int()],
            'created_at_start'         => ['type' => Type::string()],
            'created_at_end'           => ['type' => Type::string()],    

            'page'                     => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                    => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }

    public function resolve($root, $args)
    {
    $query = DetailJournal::with('journal','depense_proprio');

    if (isset($args['id']))
    {
        $query->where('id', $args['id']);
    }

    if (isset($args['created_at_start']) && isset($args['created_at_end']))
    {
        $from = $args['created_at_start'];
        $to   = $args['created_at_end'];
        // Eventuellement la date fr
        $from = (strpos($from, '/') !== false) ? \Carbon\Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
        $to   = (strpos($to, '/') !== false) ? \Carbon\Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

        $from = date($from.' 00:00:00');
        $to   = date($to.' 23:59:59');
        $query->whereBetween('created_at', [$from, $to]);
    }

    if (isset($args['journal_id']))
    {
        $query->where('journal_id', $args['journal_id']);
    }

    $count = Arr::get($args, 'count', 20);
    $page  = Arr::get($args, 'page', 1);

    // Récupérer les données paginées
    return $query->orderBy('created_at', 'desc')->paginate($count, ['*'], 'page', $page);
    }

}
