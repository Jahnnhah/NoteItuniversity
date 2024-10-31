<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Matiere;
use App\Models\Promotion;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
class SaisirNoteController extends Controller
{
    public function saisiNote(){

        $matieres = Matiere::all();
        $etudiants = Etudiant::all();

        return view("admin.saisiNote", compact("matieres","etudiants"));
    }

    public function saisiNotePost(Request $request){

        $request = $request->validate([
           'num_etu' => 'required',
           'id_matiere' => 'required|exists:matiere,id',
           'note' => 'required|numeric|between:0,20',
         ]);


         $etudiant = Etudiant::where('num_etu', $request['num_etu'])->first();

        Note::create([
            'id_etudiant' =>$etudiant->id,
            'id_matiere' => $request['id_matiere'],
            'note' => $request['note'],
        ]);

        Session::flash('success', 'Saisi note avec succès.');

        return redirect()->route('saisiNote')->with('success',  'Saisi note avec succès.');

    }


    //nouveau saisi note

        public function nouveauSaisiNote(){

            $matieres = Matiere::all();
            $promotions = Promotion::all();

            return view("admin.nouveauSaisiNote", compact("matieres","promotions"));
        }

        public function nouveauSaisiNotePost(Request $request)
        {
            // Validate the incoming request
            $request->validate([
                'id_matiere' => 'required|integer',
                'id_promotion' => 'required|integer',
                'note' => 'required|numeric'
            ]);

            // Retrieve the input data from the request
            $id_matiere = $request->input('id_matiere');
            $id_promotion = $request->input('id_promotion');
            $note = $request->input('note');

            // Get all students for the selected promotion
            $etudiants = DB::table('etudiant')
                            ->where('id_promotiom', $id_promotion)
                            ->get();

            // Iterate over each student and insert the note
            foreach ($etudiants as $etudiant) {
                DB::table('note')->insert([
                    'note' => $note,
                    'id_etudiant' => $etudiant->id,
                    'id_matiere' => $id_matiere
                ]);
            }

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Notes enregistrées avec succès pour tous les étudiants de la promotion sélectionnée.');
        }


}
