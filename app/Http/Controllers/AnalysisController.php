<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'dataset_id' => 'required|exists:datasets,id',
        ]);

        $analysis = Analysis::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'dataset_id' => $request->dataset_id,
        ]);

        return redirect()->route('datasets.show', $request->dataset_id)
                         ->with('success', 'Analysis submitted successfully.');
    }
}
