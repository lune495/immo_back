<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unites', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->nullable();
            $table->unsignedBigInteger('bien_immo_id');
            $table->foreign('bien_immo_id')->references('id')->on('bien_immos'); // Relation avec la table 'immeubles'
            $table->unsignedBigInteger('nature_local_id');
            $table->foreign('nature_local_id')->references('id')->on('nature_locals'); // Exemple : Appartement,Magasin
            $table->integer('etage')->nullable(); // Étage de l'unité
            $table->integer('montant_loyer')->nullable(); // Étage de l'unité
            $table->float('superficie_en_m2')->nullable(); // Superficie en m²
            $table->string('annee_achevement')->nullable(); // Année achevement
            $table->integer('nombre_piece_principale')->nullable(); // Nombre de chambres (applicable pour les appartements)
            $table->integer('nombre_salle_de_bain')->nullable(); // Nombre de salles de bain
            $table->boolean('balcon')->default(false); // Présence d'un balcon ou terrasse
            $table->string('type_localisation')->nullable(); // Rez-de-chaussée, 1er étage, etc. (applicable pour les magasins/bureaux)
            $table->text('description')->nullable(); // Description de l'unité
            $table->boolean('dispo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('unites');
    }
}
