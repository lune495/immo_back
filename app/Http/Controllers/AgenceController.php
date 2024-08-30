<?php

namespace App\Http\Controllers;

use App\Models\{Agence,Outil};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AgenceController extends Controller
{
    
    private $queryName = "agences";

     public function save(Request $request)
    {
        try {
            return DB::transaction(function () use ($request)
            {
                DB::beginTransaction();
                $errors =null;
                $item = new Agence();
                if (!empty($request->id))
                {
                    $item = Agence::find($request->id);
                }
                if (empty($request->nom_agence))
                {
                    $errors = "Renseignez le nom de l'agence";
                }
                if (empty($request->adresse))
                {
                    $errors = "Renseignez l'adresse de l'agence";
                }
                if (empty($request->num_fixe))
                {
                    $errors = "Renseignez le numero de l'agence";
                }
                $item->nom_agence = $request->nom_agence;
                $item->adresse = $request->adresse;
                $item->num_fixe = $request->num_fixe;
                if (!isset($errors)) 
                {
                    $item->save();
                    $id = $item->id;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
