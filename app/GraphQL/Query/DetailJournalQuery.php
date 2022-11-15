<?php

namespace App\GraphQL\Query;

use App\Models\DetailJournal;
use App\Models\Outil;
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
            'id'                => ['type' => Type::int()],
            'locataire_id'      => ['type' => Type::int()],
            'journal_id'        => ['type' => Type::int()]
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
        $query->orderBy('id', 'desc');
        $query = $query->get();

        return $query->map(function (DetailJournal $item)
        {
            return
            [
                'id'                                => $item->id,
                'libelle'                           => $item->libelle,
                'entree'                            => $item->entree,
                'sortie'                            => $item->sortie,
                'locataire_id'                      => $item->locataire_id,
                'locataire'                         => $item->locataire,
                'journal_id'                        => $item->journal_id,
                'journal'                           => $item->journal,   
            ];
        });
    }
}
