<?php

namespace App\GraphQL\Query;

use App\Models\{DetailJournal,Outil,Locataire};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class DetailJournalQuery extends Query
{
    protected $attributes =
    [
        'name' => 'detail_journals'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('DetailJournal'));
    }

    public function args():array
    {
        return
        [
            'id'                  => ['type' => Type::int()],
            'locataire_id'        => ['type' => Type::int()],
            'journal_id'          => ['type' => Type::int()],
            'created_at_start'    => ['type' => Type::string()],
            'created_at_end'      => ['type' => Type::string()],
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
            $from = (strpos($from, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $from)->format('Y-m-d') : $from;
            $to   = (strpos($to, '/') !== false) ? Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d') : $to;

            $from = date($from.' 00:00:00');
            $to   = date($to.' 23:59:59');
            $query->whereBetween('created_at', array($from, $to));

        }
        if (isset($args['journal_id']))
        {
            $query->where('journal_id', $args['journal_id']);
        }
        $query->orderBy('id', 'desc');
        $query = $query->get();

        return $query->map(function (DetailJournal $item)
        {
            return
            [
                'id'                                => $item->id,
                'code'                              => $item->code,
                'libelle'                           => $item->libelle,
                'entree'                            => $item->entree,
                'sortie'                            => $item->sortie,
                'locataire_id'                      => $item->locataire_id,
                'locataire'                         => $item->locataire,
                'proprietaire_id'                   => $item->proprietaire_id,
                'proprietaire'                      => $item->proprietaire,
                'journal_id'                        => $item->journal_id,
                'journal'                           => $item->journal,   
                'depense_proprio'                   => $item->depense_proprio, 
                'journal'                           => $item->journal,   
                'created_at_fr'                     => $item->created_at_fr,   
                'updated_at_fr'                     => $item->updated_at_fr,   
                'created_at'                        => $item->created_at->format(Outil::formatdate()),
                'updated_at'                        => $item->updated_at->format(Outil::formatdate())
            ];
        });
    }
}
