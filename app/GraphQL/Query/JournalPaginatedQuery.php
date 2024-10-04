<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{Journal,Outil,ClotureCaisse};

class JournalPaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'journalspaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('journalspaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'locataire_id'                  => ['type' => Type::int()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $query = Journal::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        // if (isset($args['locataire_id']))
        // {
        //     $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['code'].'%');
        // }
        $latestClosureDate = ClotureCaisse::orderBy('date_fermeture', 'desc')->value('date_fermeture');
        if (isset($latestClosureDate)) {
            $query = $query->whereBetween('created_at', [$latestClosureDate, now()]);
        }
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'asc')->paginate($count, ['*'], 'page', $page);
    }
}

