<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $datasets = Dataset::paginate(10); // Récupère 10 datasets par page
        $newdatasets = Dataset::latest()->take(10)->get(); // Récupère les 10 derniers datasets par date de création
    
        return view('acceuil', compact('datasets','newdatasets'));
    }

    
}
