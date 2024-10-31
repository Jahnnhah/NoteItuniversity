<?php

namespace App\Models;

use PhpParser\Node\Stmt\For_;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Note extends Model
{
    use HasFactory;

    protected $table = 'note';

    protected $fillable = [
        'note',
        'id_etudiant',
        'id_matiere',
    ];

    public $timestamps = false;

    public static function classificationNote($note)
    {

        if ($note >= 16) {
            return 'TB';
        } elseif ($note >= 14) {
            return 'B';
        } elseif ($note >= 12) {
            return 'AB';
        } elseif ($note >= 10) {
            return 'P';
        } else {
            return 'Aj';
        }
    }


    public static function getReleveDeNotes($id, $semestre)
    {
        $config = DB::table('config')->get();
        $typeCalculNote = $config->where('code', 'CONF3')->first()->valeur; // Fetch the type of calculation for notes
        $montant_rattrapage_par_matiere = $config->where('code', 'CONF4')->first()->valeur; // Fetch the catch-up fee per subject
        $limite_note_ajournee = $config->where('code', 'CONF1')->first()->valeur; // Fetch the limit for a note to be considered as "Ajournée"
        $nb_matiere_max_compensee = $config->where('code', 'CONF2')->first()->valeur; // Fetch the maximum number of subjects that can be compensated

        $releveDeNotes = V_MatiereOption::where('id_etudiant', $id)
                            ->where('id_semestre', $semestre)
                            ->select (
                                'id_etudiant',
                                'id_semestre',
                                'groupe',
                                'id_matiere',
                                'num_etu',
                                'code_matiere',
                                'nom_matiere',
                                'credit_obtenu',
                                'note',
                                'credit',
                                DB::raw('SUM(credit_obtenu) OVER (PARTITION BY id_etudiant, id_semestre) as somme_credit'),
                                DB::raw('SUM(note * credit) OVER (PARTITION BY id_etudiant, id_semestre) / SUM(credit) OVER (PARTITION BY id_etudiant, id_semestre) as moyenne_etudiant')
                            )
                            ->distinct()
                            ->orderBy('id_etudiant')
                            ->orderBy('id_semestre')
                            ->orderBy('groupe')
                            ->orderBy('id_matiere')
                            ->get();


        $nb_matiere_non_moyenne = 0;
        $nb_matiere_echec = 0; // Number of subjects below the limit note
        $nb_matiere_ajournee = 0; // Counter for subjects classified as "Ajournée"

        $moyenne = $releveDeNotes[0]->moyenne_etudiant;

        // Calculate notes based on the configuration
        foreach ($releveDeNotes as $releveDeNote) {

            // Determine if there are multiple exams for a subject and calculate note accordingly
            if ($typeCalculNote == 1) {
                // Max calculation
                $releveDeNote->note = V_MatiereOption::where('id_etudiant', $id)
                                                      ->where('id_semestre', $semestre)
                                                      ->where('id_matiere', $releveDeNote->id_matiere)
                                                      ->max('note');
            } else if ($typeCalculNote == 2) {
                // Average calculation
                $averageNote = V_MatiereOption::where('id_etudiant', $id)
                                               ->where('id_semestre', $semestre)
                                               ->where('id_matiere', $releveDeNote->id_matiere)
                                               ->avg('note');

                $releveDeNote->note = number_format($averageNote, 2); // Format to 2 decimal places
            }

            // Classify the note based on updated value
            $releveDeNote->classification = Note::classificationNote($releveDeNote->note, $releveDeNote->moyenne_etudiant);

            // Count the subjects not achieving the average
            if ($releveDeNote->note < 10) {
                $nb_matiere_non_moyenne++;
            }

            // Count the failing grades below configured limit
            if ($releveDeNote->note < $limite_note_ajournee) {
                $nb_matiere_echec++;
            }
        }

        // Compensate notes if applicable
        $total_credit = 0;

        foreach ($releveDeNotes as $releveDeNote) {

            // Compensate if conditions are met
            if ($moyenne >= 10 && $nb_matiere_non_moyenne <= $nb_matiere_max_compensee && $nb_matiere_echec == 0) {
                if ($releveDeNote->classification == 'Aj') {
                    $releveDeNote->classification = 'Comp';
                    $releveDeNote->credit_obtenu = $releveDeNote->credit;
                }
            }

            // Count the "Ajournée" subjects
            if ($releveDeNote->classification == 'Aj') {
                $nb_matiere_ajournee++;
            }

            $total_credit += $releveDeNote->credit_obtenu;
        }

        // Calculate the total amount to pay for the catch-up exams
        $montant_rattrapage = $nb_matiere_ajournee * $montant_rattrapage_par_matiere;

        // Update the first record with total credits and amount to pay
        $releveDeNotes[0]->somme_credit = $total_credit;
        $releveDeNotes[0]->montant_rattrapage = $montant_rattrapage;

        return $releveDeNotes;
    }

    public static function sum_credit_semestre($etudiant)
    {
        $semestres = Semestre::all();

        $total_credit = 0;

        foreach ($semestres as $semestre) {
            $releveDeNotes = Note::getReleveDeNotes($etudiant, $semestre->id);

            foreach ($releveDeNotes as $releveDeNote) {
                $total_credit += $releveDeNote->credit_obtenu;
            }
        }

        return $total_credit;
    }

    // sum credit par annee
    public static function sum_credit_Anne($etudiant,$anne)
    {
        $semestres = null;
        if($anne==1){
            $semestres = Semestre::where('id',1)->orwhere('id',2)->get();
        }
        if($anne==2){
            $semestres = Semestre::where('id',3)->orwhere('id',4)->get();
        }
        if($anne==3){
            $semestres = Semestre::where('id',5)->orwhere('id',6)->get();
        }


        $total_credit = 0;

        foreach ($semestres as $semestre) {
            $releveDeNotes = Note::getReleveDeNotes($etudiant, $semestre->id);

            foreach ($releveDeNotes as $releveDeNote) {
                $total_credit += $releveDeNote->credit_obtenu;
            }
        }

        return $total_credit;
    }


    public static function get_all_admis(){
        $etudiant =Etudiant::all();
        $nb_admis = 0;
        $nb_non_admin = 0;

        for ($i = 0; $i < count($etudiant);$i++) {
            $total_credit =Note::sum_credit_semestre( $etudiant[$i]->id);
            if($total_credit ==180){
                $nb_admis ++;
            }else {
            $nb_non_admin ++;
            }
        }
        $resultat =[];
        $resultat['nb_admis'] = $nb_admis;
        $resultat['nb_non_admis'] = $nb_non_admin;
        return $resultat ;
    }


    // liste etudiant admis >180 si admis
    public static function listeEtudiantAdmis(){
        $etudiant =Etudiant::all();
        $resultat =[];
        for ($i=0; $i <count($etudiant) ; $i++) {
            $total_credit =Note::sum_credit_semestre( $etudiant[$i]->id);
            if($total_credit == 180){
                $resultat[$i] = $etudiant[$i];
            }
        }

        return $resultat;
    }
    public static function listeEtudiantNonAdmis(){
        $etudiant =Etudiant::all();
        $resultat =[];
        for ($i=0; $i <count($etudiant) ; $i++) {
            $total_credit =Note::sum_credit_semestre( $etudiant[$i]->id);
            if($total_credit != 180){
                $resultat[$i] = $etudiant[$i];
            }
        }

        return $resultat;
    }

    public static function sum_credit_par_semestre($etudiant,$semestre){
       $semestre = Semestre::where('id',$semestre);


        $total_credit = 0;

            $releveDeNotes = Note::getReleveDeNotes($etudiant, $semestre->id);

            foreach ($releveDeNotes as $releveDeNote) {
                $total_credit += $releveDeNote->credit_obtenu;
            }
            return $total_credit;

    }


    public function liste_etudiant_admis_semestre($idsemestre){
        $etudiants = Etudiant::all();

        $resultat = [];


        for ($i=0; $i <count($etudiants) ; $i++) {
            $somme_credit_semestre = Note::sum_credit_par_semestre($etudiants[$i]['id'],$idsemestre);
            if($somme_credit_semestre == 30){
                $resultat[$i] = $etudiants[$i];
            }
        }
        return $resultat;

    }

    public static function somme_moyenne_generale(){

    }

    public static function getRangEtudiant($etudiant, $semestre)
        {
            // Fetch rank from the view
            $result = DB::table('v_get_rang_etudiant')
                        ->select('etudiant_rank')
                        ->where('etudiant_id', $etudiant)
                        ->where('semestre_id', $semestre)
                        ->first();

            // If the result is found, return the rank; otherwise, return null or 0
            return $result ? $result->etudiant_rank : null;
        }

}

