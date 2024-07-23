<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Column;
use App\Models\Dataset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DatasetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['download','showdataset']);
    }



    public function showImportForm()
    {
        return view('datasets.import');
    }

    public function showdataset($id){
        
        $dataset = Dataset::find($id);
        // dd($this->getStatistics($dataset));
        $statistics = $this->getStatistics($dataset);
        $graphData = $this->prepareGraphData($dataset);
        // dd($statistics);

        return view('show_dataset', compact('dataset', 'statistics', 'graphData'));

    }

    // Traite l'importation du fichier
    public function import(Request $request)
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
        $filePath = $file->store('datasets');

        if (in_array($fileExtension, ['csv', 'txt'])) {
            // Detect delimiter
            $delimiter = $this->detectDelimiter(storage_path('app/' . $filePath));

            // Read file with detected delimiter
            $fileData = array_map(function ($row) use ($delimiter) {
                return str_getcsv($row, $delimiter);
            }, file(storage_path('app/' . $filePath)));
    
            $header = array_shift($fileData);
        } elseif (in_array($fileExtension, ['xlsx', 'xls'])) {
            $fileData = Excel::toArray([], $file);
            $header = array_shift($fileData[0]);
            $fileData = $fileData[0];
        } elseif ($fileExtension === 'json') {
            $jsonData = json_decode(file_get_contents($file->getRealPath()), true);
            $header = array_keys($jsonData[0]);
            $fileData = $jsonData;
        } else {
            return redirect()->route('home')->with('error', 'Type de fichier non supporté.');
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

        // Enregistrer le fichier importé dans la base de données
        $filePath = $file->store('datasets');
        File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
            'dataset_id' => $dataset->id,
        ]);

        return redirect()->route('home')->with('success', 'Dataset importé avec succès.');
    }

    private function detectDelimiter($filePath)
{
    $sampleLines = array_slice(file($filePath), 0, 10); // Lire les premières lignes pour déterminer le délimiteur

    $delimiters = [',', ';', "\t", '|'];
    $delimiterCounts = [];

    foreach ($delimiters as $delimiter) {
        $delimiterCounts[$delimiter] = 0;

        foreach ($sampleLines as $line) {
            $delimiterCounts[$delimiter] += substr_count($line, $delimiter);
        }
    }

    // Choisir le délimiteur avec le plus grand nombre d'occurrences
    arsort($delimiterCounts);
    return key($delimiterCounts);
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

    // Télécharger le dataset
    public function download($id)
    {
        $dataset = Dataset::findOrFail($id);
        $file = $dataset->files->first();

        if ($file) {
            $path = storage_path('app/' . $file->path);
            $extension = pathinfo($file->name, PATHINFO_EXTENSION);
            $contentType = $extension == 'csv' ? 'text/csv' : ($extension == 'json' ? 'application/json' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $headers = [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
            ];

            return new StreamedResponse(function() use ($path) {
                $handle = fopen($path, 'r');
                fpassthru($handle);
                fclose($handle);
            }, 200, $headers);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    private function getColumnData(Dataset $dataset, $columnName)
    {
        $file = $dataset->files->first(); // Supposer qu'un dataset a un seul fichier principal
    
        if (!$file) {
            return []; // Aucun fichier associé au dataset
        }
    
        $filePath = storage_path('app/' . $file->path);
        $fileExtension = pathinfo($file->name, PATHINFO_EXTENSION);
    
        $data = [];
    
        if (in_array($fileExtension, ['csv', 'txt'])) {
            // Lire le fichier CSV ou TXT
            if (($handle = fopen($filePath, 'r')) !== false) {
                $header = fgetcsv($handle); // Lire l'en-tête
                $columnIndex = array_search($columnName, $header); // Trouver l'index de la colonne
    
                if ($columnIndex !== false) {
                    while (($row = fgetcsv($handle)) !== false) {
                        if (isset($row[$columnIndex])) {
                            $data[] = $row[$columnIndex]; // Extraire les données de la colonne
                        }
                    }
                }
                fclose($handle);
            }
        } elseif (in_array($fileExtension, ['xlsx', 'xls'])) {
            // Lire le fichier Excel
            $fileData = Excel::toArray([], $filePath);
            $header = $fileData[0][0]; // Supposer que le premier tableau contient les en-têtes
            $columnIndex = array_search($columnName, $header); // Trouver l'index de la colonne
    
            if ($columnIndex !== false) {
                foreach ($fileData[0] as $row) {
                    if (isset($row[$columnIndex])) {
                        $data[] = $row[$columnIndex]; // Extraire les données de la colonne
                    }
                }
            }
        } elseif ($fileExtension === 'json') {
            // Lire le fichier JSON
            $jsonData = json_decode(file_get_contents($filePath), true);
    
            if (isset($jsonData[0])) {
                $header = array_keys($jsonData[0]); // Obtenir les clés du premier élément comme en-tête
                $columnIndex = array_search($columnName, $header); // Trouver l'index de la colonne
    
                if ($columnIndex !== false) {
                    foreach ($jsonData as $row) {
                        if (isset($row[$columnName])) {
                            $data[] = $row[$columnName]; // Extraire les données de la colonne
                        }
                    }
                }
            }
        }
    
        return $data;
    }
    
    
    private function getStatistics(Dataset $dataset)
    {
        $statistics = [];
        $columns = $dataset->columns;
        // dump($columns);

        foreach ($columns as $column) {
            $data = $this->getColumnData($dataset, $column->name);
            if ($data) {
                $statistics[$column->name] = $this->calculateStatistics($data);
            }
        }
        // dd($statistics);
        return $statistics;
    }

    private function calculateStatistics(array $data)
    {
        $mean = array_sum($data) / count($data);
        $median = $this->calculateMedian($data);
        $stdDev = $this->calculateStandardDeviation($data, $mean);

        return [
            'mean' => $mean,
            'median' => $median,
            'stdDev' => $stdDev,
        ];
    }

    private function calculateMedian(array $data)
    {
        // Assurez-vous que les données sont des nombres et non des chaînes
        $data = array_map('floatval', $data);
    
        // Trier les données
        sort($data);
    
        $count = count($data);
        $middle = intdiv($count, 2); // Division entière pour obtenir l'indice du milieu
    
        // Calculer la médiane
        if ($count % 2) {
            // Nombre impair d'éléments
            return $data[$middle];
        } else {
            // Nombre pair d'éléments
            return ($data[$middle - 1] + $data[$middle]) / 2.0;
        }
    }
    

    private function calculateStandardDeviation(array $data, $mean)
    {
        // Convertir les données et la moyenne en nombres
        $data = array_map('floatval', $data);
        $mean = floatval($mean);
    
        // Calculer les différences au carré
        $squaredDifferences = array_map(fn($value) => pow($value - $mean, 2), $data);
    
        // Calculer la moyenne des différences au carré
        $meanSquaredDifference = array_sum($squaredDifferences) / count($data);
    
        // Retourner l'écart-type
        return sqrt($meanSquaredDifference);
    }
    

    private function prepareGraphData(Dataset $dataset)
    {
        $graphData = [];
        $columns = $dataset->columns;

        foreach ($columns as $column) {
            $data = $this->getColumnData($dataset, $column->name);
            if ($data) {
                $graphData[$column->name] = $data;
            }
        }

        return $graphData;
    }

  
}
