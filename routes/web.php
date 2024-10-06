<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LocataireController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/journalpdf/{start?}/{end?}/{token?}', [JournalController::class,'generePDfGrandJournal']);
Route::get('/doc', [LocataireController::class,'documentation']);
Route::get('/situation-par-proprio-pdf/{id?}/{mois?}/{token?}', [JournalController::class,'generatesituationparproprio']);
Route::get('/situation-par-locataire-pdf/{id?}/{start?}/{end?}/{token?}', [LocataireController::class,'generatesituationparlocataire']);
Route::get('/quittance-pdf/{id?}/{token?}', [LocataireController::class,'generatequittancelocataire']);
Route::get('/situation-generale-par-proprio-pdf/{id}/{token?}', [JournalController::class,'situationgeneralparproprio']);
Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-auth', function () {
    return Auth::user() ? Auth::user() : 'User is not authenticated';
})->middleware('auth:sanctum');