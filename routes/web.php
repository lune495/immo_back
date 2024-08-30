<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\LocataireController;

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

Route::get('/journalpdf/{start?}/{end?}', [JournalController::class,'generePDfGrandJournal']);
Route::get('/situation-par-proprio-pdf/{id?}/{start?}/{end?}', [JournalController::class,'generatesituationparproprio']);
Route::get('/situation-par-locataire-pdf/{id?}/{start?}/{end?}', [LocataireController::class,'generatesituationparlocataire']);
Route::get('/quittance-pdf/{id?}', [LocataireController::class,'generatequittancelocataire']);
Route::get('/situation-generale-par-proprio-pdf/{id}', [JournalController::class,'situationgeneralparproprio']);
Route::get('/', function () {
    return view('welcome');
});