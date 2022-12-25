<?php

namespace App\GraphQL\Query;

use  App\Models\{Journal,Outil,DetailJournal};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class JournalProprioQuery extends Query
{
    protected $attributes = [
        'name' => 'journal_proprios'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('JournalProprio'));
    }

    public function args():array
    {
        return
        [
            'proprio_id'               => ['type' => Type::int()],
            'created_at_start'         => ['type' => Type::string()],
            'created_at_end'           => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = DetailJournal::query();
        if (isset($args['proprio_id']))
        {
            $query = $query->join('locataires','locataires.id','=','detail_journals.locataire_id')
                           ->join('bien_immos','bien_immos.id','=', 'locataires.bien_immo_id')
                           ->where('bien_immos.proprietaire_id',$args['proprio_id'])
                           ->selectRaw('detail_journals.*');
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();

        return $query->map(function (DetailJournal $item)
        {
            return
            [
                'id'                                => $item->id,
                'entree'                            => $item->entree,
                'sortie'                            => $item->sortie
            ];
        });
    }
}
