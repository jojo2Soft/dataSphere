<?php

namespace App\Http\Controllers\Api;

use App\Models\Column;
use App\Models\Dataset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class DatasetController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls,json|max:2048',
        ]);

        $file = $request->file('file');
        $datasetName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // Créer un nouveau dataset
        $dataset = Dataset::create([
            'name' => $datasetName,
            'description' => $request->input('description', ''),
            'user_id' => auth()->id(), // Associe l'utilisateur actuellement connecté
        ]);

        // Lire le fichier et créer les colonnes
        $fileExtension = $file->getClientOriginalExtension();
        if (in_array($fileExtension, ['csv', 'txt'])) {
            $fileData = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($fileData);
        } elseif (in_array($fileExtension, ['xlsx', 'xls'])) {
            $fileData = Excel::toArray([], $file);
            $header = array_shift($fileData[0]);
        } else {
            $fileData = json_decode(file_get_contents($file->getRealPath()), true);
            $header = array_keys($fileData[0]);
        }

        // Détecter le type de chaque colonne
        $columnTypes = $this->detectColumnTypes($fileData, $header);

        // Créer les colonnes dans la base de données
        foreach ($header as $index => $columnName) {
            Column::create([
                'name' => $columnName,
                'type' => $columnTypes[$index],
                'dataset_id' => $dataset->id,
            ]);
        }

        // Enregistrer le fichier
        $filePath = $file->storeAs('datasets', $file->getClientOriginalName());
        $dataset->files()->create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
        ]);

        return response()->json(['message' => 'Dataset uploaded successfully.'], 200);
    }

    public function download(Dataset $dataset)
    {
        $file = $dataset->files()->first(); // Assumant qu'un dataset a un fichier principal
        if (!$file) {
            return response()->json(['message' => 'File not found.'], 404);
        }

        return Storage::download($file->path, $file->name);
    }

    private function detectColumnTypes($fileData, $header)
    {
        $types = array_fill(0, count($header), 'string'); // Valeur par défaut

        foreach ($fileData as $row) {
            foreach ($row as $index => $value) {
                if (isset($value)) {
                    if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                        $types[$index] = 'integer';
                    } elseif (filter_var($value, FILTER_VALIDATE_FLOAT) !== false) {
                        $types[$index] = 'float';
                    } elseif (strtolower($value) === 'true' || strtolower($value) === 'false') {
                        $types[$index] = 'boolean';
                    }
                }
            }
        }

        return $types;
    }
}
