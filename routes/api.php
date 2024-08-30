<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgenceController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\BienImmoController;
use App\Http\Controllers\BienController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaxeController;
use App\Http\Controllers\NatureLocationController;
use App\Http\Controllers\TypeBienImmoController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\DepenseProprioController;
// use App\Http\Controllers\AffectationBienController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Public Routes
//Route::resource('produits', ProduitController::class);
Route::post('/agence',[AgenceController::class, 'save']);
Route::post('/typebien',[TypeBienImmoController::class, 'save']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/proprietaire',[ProprietaireController::class,'save']);
Route::post('/unite',[UniteController::class,'save']);
Route::post('/taxe',[TaxeController::class,'save']);
Route::post('/nature_location',[NatureLocationController::class,'save']);
Route::post('/depense_proprio',[DepenseProprioController::class,'save']);
Route::post('/locataire',[LocataireController::class,'save']);
Route::post('/bienimmo',[BienImmoController::class,'save']);
Route::put('/bienimmo_update/{id}', [BienImmoController::class, 'update']);
Route::post('/journal',[JournalController::class,'save']);
Route::post('/resilier_contrat/{id}',[LocataireController::class,'resilier']);
Route::post('/upload_contract', [LocataireController::class, 'uploadContract']);
Route::get('/upload/{id?}', function () {
    return view('pdf.upload');
});
// Route::post('/affectationbien',[AffectationBienController::class,'save']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']],function()
{
    // Route::post('/agences',[AgenceController::class,'save']);
    // Route::delete('/proprietaires/{id}',[ProprietaireController::class,'delete']);
});