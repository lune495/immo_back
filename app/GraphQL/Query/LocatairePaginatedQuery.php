<?php

namespace App\GraphQL\Query;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Illuminate\Support\Arr;
use \App\Models\{Locataire,Outil,CompteLocataire};
use Illuminate\Support\Facades\Auth;

class LocatairePaginatedQuery extends Query
{
    protected $attributes = [
        'name'              => 'locatairespaginated',
        'description'       => ''
    ];

    public function type():type
    {
        return GraphQL::type('locatairespaginated');
    }

    public function args():array
    {
        return
        [
            'id'                            => ['type' => Type::int()],
            'nom'                           => ['type' => Type::string()],
            'prenom'                        => ['type' => Type::string()],
            'code'                          => ['type' => Type::string()],
            'loc'                           => ['type' => Type::boolean()],
            'en_regle'                      => ['type' => Type::boolean()],
        
            'page'                          => ['name' => 'page', 'description' => 'The page', 'type' => Type::int() ],
            'count'                         => ['name' => 'count',  'description' => 'The count', 'type' => Type::int() ]
        ];
    }


    public function resolve($root, $args)
    {
        $user = Auth::user();
        $query = Locataire::with('compte_locataires');
        // Filtrer les propriétaires dont la structure_id de l'utilisateur associé correspond à celui de l'utilisateur connecté
        if ($user && $user->structure_id) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('structure_id', $user->structure_id);
            });
        }
        if (isset($args['id']))
        {
            $query->where('id', $args['id']);
        }
        if (isset($args['code']))
        {
            $query = $query->where('code',Outil::getOperateurLikeDB(),'%'.$args['code'].'%');
        }
        if (isset($args['nom']))
        {
            $query = $query->where('nom',Outil::getOperateurLikeDB(),'%'.$args['nom'].'%');
        }
        if (isset($args['prenom']))
        {
            $query = $query->where('prenom',Outil::getOperateurLikeDB(),'%'.$args['prenom'].'%');
        }

        if (isset($args['id']) && isset($args['loc']) && $args['loc']  == true)
        {
            $data = [];
    
            // Récupérer les transactions pour le locataire 
            $transactions = CompteLocataire::where('locataire_id', $args['id'])->get();
            $locataireId = $args['id'];
            // Initialisation des variables
            $totalCredits = 0;
            $totalDebits = 0;
            $balance = 0;
            $records = [];
            // Récupérer les informations du locataire
            $locataire =  Locataire::find($locataireId);
            // Processer les transactions
            foreach ($transactions as $transaction) {
                // Assurez-vous que $transaction->dernier_date_paiement est un objet Carbon
                $date = \Carbon\Carbon::parse($transaction->dernier_date_paiement)->format('d/m/Y');
                if ($transaction->credit > 0) {
                    // Si le montant est positif, c'est un crédit
                    $totalCredits += $transaction->credit;
                    $balance += $transaction->credit;
                } else {
                    // Si le montant est négatif, c'est un débit
                    $totalDebits += abs($transaction->credit); // Le montant est négatif, donc prendre la valeur absolue
                    $balance += $transaction->credit;
                }
    
                // Ajouter les données au tableau des enregistrements
                $records[] = [
                    'date' => $date,
                    'debit' => $transaction->credit < 0 ? abs($transaction->credit) : 0,
                    'credit' => $transaction->credit > 0 ? $transaction->credit : 0,
                    'balance' => $balance,
                ];
            }
    
            // // Trier les enregistrements par date
            // usort($records, function ($a, $b) {
            //     return strtotime($a['date']) - strtotime($b['date']);
            // });
    
            // Préparer les données pour la vue
            $data['records'] = $records;
            $data['totalCredits'] = $totalCredits;
            $data['totalDebits'] = $totalDebits;
            $data['balance'] = $balance;
            $data['locataire'] = $locataire;
            // return $data;
        }
        

        if (isset($args['en_regle'])) {
            if ($args['en_regle']) {
                // Locataires en règle (solde égal à 0)
                $query->where('solde', 0);
            } else {
                // Locataires non en règle (solde supérieur à 0)
                $query->where('solde', '>', 0);
            }
        }
        
        
        $count = Arr::get($args, 'count', 10);
        $page  = Arr::get($args, 'page', 1);

        return $query->orderBy('id', 'asc')->paginate($count, ['*'], 'page', $page);
    }
}

