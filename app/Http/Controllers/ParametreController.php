<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use Illuminate\Support\Facades\Validator;


class ParametreController extends Controller
{
    public function showParametre()
    {
        // Retrieve all parameters from the database in ascending order by 'id'
        $parametres = Parametre::orderBy('id', 'asc')->get();

        // Return the view with the parameters
        return view('admin.modifierParametre', compact('parametres'));
    }

    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'borneinf' => 'required|numeric',
            'bornesup' => 'required|numeric|gt:borneinf',
            'couleur' => 'required|string',
        ]);

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newBorneInf = $request->borneinf;
        $newBorneSup = $request->bornesup;

        // Retrieve all existing intervals from the database
        $existingParametres = Parametre::all();

        // Check for overlapping intervals
        foreach ($existingParametres as $parametre) {
            if (($newBorneInf >= $parametre->borneinf && $newBorneInf < $parametre->bornesup) ||
                ($newBorneSup > $parametre->borneinf && $newBorneSup <= $parametre->bornesup)) {
                return redirect()->back()->withErrors(['error' => 'The new interval overlaps with an existing one.']);
            }
        }

        // Optionally, check the last used ID if you're manually handling IDs (not recommended)
        if ($request->has('id')) {
            $lastId = Parametre::max('id');
            if ($request->id <= $lastId) {
                return redirect()->back()->withErrors(['error' => 'The ID already exists.']);
            }
        }

        // Create and save the new parameter
        $parametre = new Parametre();
        $parametre->borneinf = $newBorneInf;
        $parametre->bornesup = $newBorneSup;
        $parametre->couleur = $request->couleur;
        $parametre->save();

        return redirect()->route('parametre.index')->with('success', 'Parameter added successfully.');
    }

    public function updateParametre(Request $request, $id)
        {
            // Retrieve the existing intervals from the database
            $existingParametres = Parametre::where('id', '!=', $id)->get();

            // Validate the input
            $validator = Validator::make($request->all(), [
                'borneinf' => 'required|numeric',
                'bornesup' => 'required|numeric|gt:borneinf',
                'couleur' => 'required|string',
            ]);

            $newBorneInf = $request->borneinf;
            $newBorneSup = $request->bornesup;

            // Check for overlapping intervals
            foreach ($existingParametres as $parametre) {
                if (($newBorneInf >= $parametre->borneinf && $newBorneInf < $parametre->bornesup) ||
                    ($newBorneSup > $parametre->borneinf && $newBorneSup <= $parametre->bornesup)) {
                    return redirect()->back()->withErrors(['error' => 'The new interval overlaps with an existing one.']);
                }
            }

            // If validation passes, save the new parameter
            $parametre = Parametre::find($id);
            $parametre->borneinf = $newBorneInf;
            $parametre->bornesup = $newBorneSup;
            $parametre->couleur = $request->couleur;
            $parametre->save();

            return redirect()->route('parametre.index')->with('success', 'Parameter updated successfully.');
        }

        public function destroy($id)
            {
                // Find the parameter by ID and delete it
                $parametre = Parametre::find($id);
                if ($parametre) {
                    $parametre->delete();
                    return redirect()->route('parametre.index')->with('success', 'Parameter deleted successfully.');
                } else {
                    return redirect()->route('parametre.index')->withErrors(['error' => 'Parameter not found.']);
                }
            }

}
