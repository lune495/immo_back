<?php

namespace App\GraphQL\Query;

use  App\Models\{Unite};
use Carbon\Carbon;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

class UniteQuery extends Query
{
    protected $attributes = [
        'name' => 'unite'
    ];

    public function type():type
    {
        return Type::listOf(GraphQL::type('Unite'));
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
        $query = Unite::with('bien_immo','nature_local');
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }

        $query->orderBy('id', 'desc');
        $query = $query->get();

        return $query->map(function (Unite $item)
        {
            return
            [
                'id'                         =>     $item->id,     
                'bien_immo'                  =>     $item->bien_immo, 
                'nature_local'               =>     $item->nature_local, 
                'etage'                      =>     $item->etage, 
                'superficie_en_m2'           =>     $item->superficie_en_m2, 
                'annee_achevement'           =>     $item->annee_achevement, 
                'nombre_piece_principale'    =>     $item->nombre_piece_principale, 
                'nombre_salle_de_bain'       =>     $item->nombre_salle_de_bain, 
                'balcon'                     =>     $item->balcon,
                'locataires'                 =>     $item->locataires,
                'montant_loyer'              =>     $item->montant_loyer,
                'type_localisation'          =>     $item->type_localisation,
                'dispo'                      =>     $item->dispo,
                'numero'                     =>     $item->numero,
            ];
        });
    }
}
