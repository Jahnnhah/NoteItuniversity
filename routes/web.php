<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\ImportNoteController;
use App\Http\Controllers\SaisirNoteController;
use App\Http\Controllers\ListeEtudiantController;
use App\Http\Controllers\ListeSemestreEtudiantController;
use App\Http\Controllers\ListeSemestreAdminController;
use App\Http\Controllers\ParametreController;

Route::get('/homeClient', [AuthenController::class, 'homeClient'])->name('homeClient');
Route::get('/homeAdmin', [AuthenController::class, 'homeAdmin'])->name('homeAdmin');
Route::get('/', [AuthenController::class, 'loginClient'])->name('loginClient');
Route::post('/loginClientPost', [AuthenController::class, 'loginClientPost'])->name('loginClientPost');





// route admin
Route::get('/admin', [AuthenController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('/loginAdminPost', [AuthenController::class, 'loginAdminPost'])->name('loginAdminPost');
Route::get('/saisiNote', [SaisirNoteController::class, 'saisiNote'])->name('saisiNote');
Route::post('/saisiNotePost', [SaisirNoteController::class, 'saisiNotePost'])->name('saisiNotePost');
Route::get('/listeEtudiant', [ListeEtudiantController::class, 'listeEtudiant'])->name('listeEtudiant');
Route::post('/filtrageEtudiant', [ListeEtudiantController::class, 'filtrageEtudiant'])->name('filtrageEtudiant');
Route::get('/listesemestre/{id}', [ListeEtudiantController::class, 'listesemestre'])->name('listesemestre');
Route::get('/etudiant/{id}/{semestre}/releveDeNote', [ListeEtudiantController::class, 'releveDeNote'])->name('releveDeNote');
Route::get('/listeanne/{id}', [ListeEtudiantController::class, 'listeanne'])->name('listeanne');

Route::get('/listeSemestreAdmin', [ListeSemestreAdminController::class, 'listeSemestreAdmin'])->name('listeSemestreAdmin');
Route::get('/listeEtudiantSemestreAdmin/{id}/etudiants', [ListeSemestreAdminController::class, 'listeEtudiantSemestreAdmin'])->name('listeEtudiantSemestreAdmin');

Route::get('/etudiant/{id}/{anne}/releveDeNoteAnne', [ListeEtudiantController::class, 'releveDeNoteAnne'])->name('releveDeNoteAnne');


// route etudiant
Route::get('/listesemestreEtudiant', [ListeSemestreEtudiantController::class, 'listesemestreEtudiant'])->name('listesemestreEtudiant');
Route::get('/releveDeNoteEtudiant/{id}', [ListeSemestreEtudiantController::class, 'releveDeNoteEtudiant'])->name('releveDeNoteEtudiant');


// import note etudiant avec configuration
Route::get('/importConfig', [ImportController::class, 'importConfig'])->name('importConfig');
Route::post('/importConfigPost', [ImportController::class, 'importConfigPost'])->name('importConfigPost');
Route::get('/importNote', [ImportNoteController::class, 'importNote'])->name('importNote');
Route::post('/importNoteEtudiantPost', [ImportNoteController::class, 'importNoteEtudiantPost'])->name('importNoteEtudiantPost');
Route::get('/modifierConfig', [ImportController::class, 'modifierConfig'])->name('modifierConfig');
Route::put('/modifierConfig/{id}', [ImportController::class, 'modifierConfigPost'])->name('modifierConfigPost');

//////////////////////eto

Route::get('/parametre', [ParametreController::class, 'showParametre'])->name('parametre.index');
Route::put('/parametre/{id}', [ParametreController::class, 'updateParametre'])->name('parametre.update');
Route::post('/parametre/store', [ParametreController::class, 'store'])->name('parametre.store');
Route::delete('/parametres/{id}', [ParametreController::class, 'destroy'])->name('parametre.destroy');


Route::get('/resetBase', [DatabaseController::class, 'index'])->name('index');
Route::post('/resetBase', [DatabaseController::class, 'resetBase'])->name('resetBase');









Route::get('/listeSemestreEtudiant', [ListeEtudiantController::class, 'listeSemestreEtudiant'])->name('listeSemestreEtudiant');

Route::get('/listeEtudiantAdminSemestre', [ListeEtudiantController::class, 'listeEtudiantAdminSemestre'])->name('listeEtudiantAdminSemestre');


// liste des etudiants qui n est pas admis en lisenece
Route::get('/listeadmis', [ListeEtudiantController::class, 'listeadmis'])->name('listeadmis');






//nouveau saisi note
Route::get('/nouveauSaisiNote', [SaisirNoteController::class, 'nouveauSaisiNote'])->name('nouveauSaisiNote');
Route::post('/nouveauSaisiNotePost', [SaisirNoteController::class, 'nouveauSaisiNotePost'])->name('nouveauSaisiNotePost');
