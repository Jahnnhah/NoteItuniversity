<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Import;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function importConfig(){

        return view("admin.importConfig");
    }

    public function importConfigPost(Request $request){

        $request->validate([
            'fileConfig'=>['required'],
        ]);
        $configeNote =$request->file('fileConfig');

        try {
            $filename1 = "CSV1_".time().".".$configeNote->getClientOriginalExtension();


            $path1 = 'data/'. $filename1;

            $configeNote->move(storage_path('data/'), $filename1);

            $import = new Import();

            $errors = $import->importDonne($path1);


            if (count($errors) > 0) {
                return back()->with([
                    'errtm' => $errors
                ]);
            }

            // Si l'importation est réussie
            return back()->with([
                'message' => 'Import terminé'
            ]);

        } catch (\Exception $e) {
            // En cas d'exception
            $errors[] = $e->getMessage();
            return back()->with('cath', $errors);
        }
     }

    public function modifierConfig(){
        $configs = Config::orderBy('id', 'asc')->get();

        // Return the data to a Blade view named 'config.index'
        return view('admin.modifierConfig', compact('configs'));
    }
    public function modifierConfigPost(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'valeur' => 'required|numeric',
        ]);

        // Find the config by ID
        $config = Config::findOrFail($id);

        // Update the valeur field
        $config->valeur = $request->input('valeur');
        $config->save();

        // Redirect back to the config list with a success message
        return redirect()->route('modifierConfig')->with('success', 'Valeur updated successfully.');
    }
}
