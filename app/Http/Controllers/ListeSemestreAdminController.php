<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semestre;
use Illuminate\Support\Facades\DB;

class ListeSemestreAdminController extends Controller
{
    public function listeSemestreAdmin()
    {

        $semestres = Semestre::all();

        return view('admin.listeSemestreAdmin', compact('semestres'));
    }

    public function listeEtudiantSemestreAdmin($id)
    {
        // Fetch students and their ranks for the given semester from the view
        $etudiants = DB::table('v_get_rang_etudiant')
            ->where('semestre_id', $id)
            ->orderBy('etudiant_rank', 'asc')
            ->get();

        // Pass the data to the Blade view
        return view('admin.listeEtudiantAdminSemestre', compact('etudiants', 'id'));
    }

}
