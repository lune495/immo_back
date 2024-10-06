<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{BienImmo,Unite,Outil,Proprietaire};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class BienImmoController extends Controller
{
    private $queryName = "bien_immos";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new BienImmo();
                $user = Auth::user();
                if (!empty($request->id))
                {
                    $item = BienImmo::find($request->id);
                }
                if (empty($request->nom_immeuble))
                {
                    $errors = "Renseignez le nom du Bien Immobilier";
                }

                // if (empty($request->adresse))
                // {
                //     $errors = "Renseignez l'adresse du Bien immobiler";
                // }

                if (empty($request->proprietaire_id))
                {
                    $errors = "Renseignez le proprietaire du Bien immobiler";
                }
                // if (empty($request->nbr_etage))
                // {
                //     $errors = "Renseignez le nombre d'etage du Bien immobiler";
                // }
                // if (empty($request->nbr_total_appartement))
                // {
                //     $errors = "Renseignez le nombre total d'appartement";
                // }
                // if (empty($request->nbr_magasin))
                // {
                //     $errors = "Renseignez le nombre de nbr_magasin";
                // }
                // if (empty($request->description))
                // {
                //     $errors = "Renseignez la description du Bien Immobilier";
                // }
                $item->code = "000001";
                $item->description = $request->description;
                $item->nom_immeuble = $request->nom_immeuble;
                $item->adresse = $request->adresse;
                $item->proprietaire_id = $request->proprietaire_id;
                $item->nbr_etage = $request->nbr_etage;
                $item->nbr_total_appartement = $request->nbr_total_appartement;
                $item->nbr_magasin = $request->nbr_magasin;
                $item->commission_agence = $request->commission_agence;
                $item->user_id = $user->id;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
                    $item->code = "GB0000-{$id}";
                    $item->save();
                    $proprio = Proprietaire::with('bien_immos')->find($item->proprietaire_id);
                    $nbr_bien = count($proprio->bien_immos);
                    $proprio_id = $proprio->id;
                    $proprio->code = "B000{$proprio_id}/{$nbr_bien}";
                    $proprio->save();
                }
                if (isset($errors))
                {
                    throw new \Exception($errors);
                }
                DB::commit();
                return  Outil::redirectgraphql($this->queryName, "id:{$id}", Outil::$queries[$this->queryName]);
          });
        } catch (exception $e) {            
             DB::rollback();
             return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            return DB::transaction(function () use ($request, $id) {

                $bienImmo = BienImmo::find($id);

                if (!$bienImmo) {
                    throw new \Exception("Bien immobilier non trouvé");
                }

                $bienImmo->description = $request->description ?? $bienImmo->description;
                $bienImmo->nom_immeuble = $request->nom_immeuble ?? $bienImmo->nom_immeuble;
                $bienImmo->adresse = $request->adresse ?? $bienImmo->adresse;
                $bienImmo->proprietaire_id = $request->proprietaire_id ?? $bienImmo->proprietaire_id;
                $bienImmo->nbr_etage = $request->nbr_etage ?? $bienImmo->nbr_etage;
                $bienImmo->nbr_total_appartement = $request->nbr_total_appartement ?? $bienImmo->nbr_total_appartement;
                $bienImmo->nbr_magasin = $request->nbr_magasin ?? $bienImmo->nbr_magasin;

                $bienImmo->save();

                if ($request->has('unites')) {
                    $existingUnites = $bienImmo->unites->pluck('id')->toArray();
                    $updatedUnites = [];

                    foreach ($request->unites as $uniteData) {
                        $unite = Unite::updateOrCreate(
                            ['id' => $uniteData['id'] ?? null, 'bien_immo_id' => $bienImmo->id],
                            [
                                'nature_local_id' => $uniteData['nature_local_id'],
                                'numero' => $uniteData['numero'],
                                'etage' => $uniteData['etage'],
                                'montant_loyer' => $uniteData['montant_loyer'],
                                'superficie_en_m2' => $uniteData['superficie_en_m2'],
                                'annee_achevement' => $uniteData['annee_achevement'],
                                'nombre_piece_principale' => $uniteData['nombre_piece_principale'],
                                'nombre_salle_de_bain' => $uniteData['nombre_salle_de_bain'],
                                'balcon' => $uniteData['balcon'],
                                'type_localisation' => $uniteData['type_localisation']
                            ]
                        );

                        $updatedUnites[] = $unite->id;
                    }

                    // Supprimer les unités qui ne sont plus dans la liste envoyée depuis le front-end
                    $unitsToDelete = array_diff($existingUnites, $updatedUnites);
                    Unite::whereIn('id', $unitsToDelete)->delete();
                }

                DB::commit();

                return response()->json(['message' => 'Bien immobilier mis à jour avec succès', 'bienImmo' => $bienImmo]);
            });
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
}

}
