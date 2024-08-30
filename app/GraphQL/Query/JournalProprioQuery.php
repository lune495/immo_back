<?php

namespace App\GraphQL\Query;

use  App\Models\{Journal,Outil,DetailJournal,Locataire};
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
            'proprio_id_entree'        => ['type' => Type::int()],
            'locataire_id'             => ['type' => Type::int()],
            'proprio_id_sortie'        => ['type' => Type::int()],
            'date_location'            => ['type' => Type::string()],
            'created_at_start'         => ['type' => Type::string()],
            'created_at_end'           => ['type' => Type::string()],
        ];
    }

    public function resolve($root, $args)
    {
        $query = DetailJournal::query();
        $attente = 0;
        if (isset($args['proprio_id_entree']))
        {
            $query = $query->join('locataires','locataires.id','=','detail_journals.locataire_id')
                           ->join('bien_immos','bien_immos.id','=', 'locataires.bien_immo_id')
                           ->where('bien_immos.proprietaire_id',$args['proprio_id_entree'])
                           ->selectRaw('detail_journals.*');
        }
        if (isset($args['locataire_id']) && isset($args['date_location']))
        {
            $locataire = Locataire::where('id','=',$args['locataire_id'])->first();
            $date_location = $locataire ? $locataire->created_at : "";
            $attente = $locataire->montant_loyer_ttc;
            if($locataire)
            {
                $toDate = Carbon::parse($args['date_location']);
                $fromDate = Carbon::parse($date_location);
                $months = $toDate->diffInMonths($fromDate);
                $attente = $toDate >= $fromDate ? round($attente * ($months + 1)) : 0;
            }
        }
        if (isset($args['locataire_id']))
        {
            $query = $query->join('locataires','locataires.id','=','detail_journals.locataire_id')
                           ->where('locataires.id',$args['locataire_id'])
                           ->selectRaw('detail_journals.*');
        }
        if (isset($args['proprio_id_sortie']))
        {
            $query = $query->where('proprietaire_id',$args['proprio_id_sortie']);
        }
        if (isset($args['created_at_start']) && isset($args['created_at_end'])) {
            $query = $query->whereBetween('detail_journals.created_at', [
                Carbon::parse($args['created_at_start'])->startOfDay(),
                Carbon::parse($args['created_at_end'])->endOfDay()
            ]);
        }
        $query->orderBy('id', 'asc');
        $query = $query->get();
        // dd($attente);
        return $query->map(function (DetailJournal $item) use ($attente)
        {
            return
            [
                'id'                                => $item->id,
                'locataire'                         => $item->locataire,
                'libelle'                           => $item->libelle,
                'entree'                            => $item->entree,
                'sortie'                            => $item->sortie,
                'date_location'                     => $item->date_location,
                'locataire'                         => $item->locataire,
                'attente'                           => $attente,
                'depense_proprio'                   => $item->depense_proprio,
                'created_at'                        => $item->created_at
            ];
        });
    }
}