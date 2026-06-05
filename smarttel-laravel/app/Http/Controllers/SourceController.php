<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ImportHistory;

class SourceController extends Controller
{
    /**
     * Afficher la page Sources avec l’historique des imports
     */
    public function index()
    {
        $imports = ImportHistory::latest()->get();
        return view('sources', compact('imports'));
    }

    /**
     * Importer un fichier CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $filename = $file->getClientOriginalName();

        try {
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle);

            DB::beginTransaction();

            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                DB::table('customers')->updateOrInsert(
                    ['customer_id' => $data['customerID']],
                    [
                        'gender' => $data['gender'] ?? null,
                        'senior_citizen' => $data['SeniorCitizen'] ?? 0,
                        'partner' => $data['Partner'] ?? null,
                        'dependents' => $data['Dependents'] ?? null,
                    ]
                );
            }

            DB::commit();

            ImportHistory::create([
                'filename' => $filename,
                'status' => 'Succès',
            ]);

            return redirect()->route('sources.index')->with('success', 'Importation réussie !');

        } catch (\Exception $e) {
            DB::rollBack();

            ImportHistory::create([
                'filename' => $filename,
                'status' => 'Erreur',
            ]);

            return redirect()->route('sources.index')->with('error', 'Erreur lors de l’import : ' . $e->getMessage());
        }
    }

    /**
     * Ajouter une API comme source
     */
    public function api(Request $request)
    {
        $request->validate([
            'api_url' => 'required|url',
        ]);

        DB::table('api_sources')->insert([
            'url' => $request->api_url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('sources.index')->with('success', 'API ajoutée avec succès !');
    }
}
