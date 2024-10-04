<?php

namespace App\GraphQL\Query;

use  App\Models\{Journal,Outil,ClotureCaisse};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class JournalQuery extends Query
{
    protected $attributes = [
        'name' => 'journals'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Journal'));
    }

    public function args():array
    {
        return
        [
            'id'                       => ['type' => Type::int()],
            'created_at_start'         => ['type' => Type::string()],
            'created_at_end'           => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = Journal::query();
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['created_at_start']) && isset($args['created_at_end']))
        {
            $from = $args['created_at_start'];
            $to   = $args['created_at_end'];

            // Eventuellement la date fr
            $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
            $to   = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

            $from = date($from.' 00:00:00');
            $to   = date($to.' 23:59:59');
            $query->whereBetween('created_at', array($from, $to));
        }
        $latestClosureDate = ClotureCaisse::orderBy('date_fermeture', 'desc')->value('date_fermeture');
        if (isset($latestClosureDate)) {
            $query = $query->whereBetween('created_at', [$latestClosureDate, now()]);
        }

        $query = $query->get();

        return $query->map(function (Journal $item)
        {
            return
            [
                'id'                                => $item->id,
                'solde'                             => $item->solde,
                'detail_journals'                   => $item->detail_journals,
                'created_at'                        => $item->created_at->format(Outil::formatdate()),
                'updated_at'                        => $item->updated_at->format(Outil::formatdate())
            ];
        });
    }
}
