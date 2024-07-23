<?php

use App\Models\User;
use App\Models\Dataset;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DatasetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $datasets = Dataset::paginate(10); // Récupère 10 datasets par page
    $newdatasets = Dataset::latest()->take(10)->get(); // Récupère les 10 derniers datasets par date de création

    return view('acceuil', compact('datasets','newdatasets'));
})->name('acceuil');


// Route::get('/api-docs', function () {
//     return view('api-doc');
// })->name('api-docs');
Route::get('/communautes', function () {
    $users = User::paginate(6);
    return view('communaute', compact('users'));
})->name('communautes');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/show-dataset/{id}', [DatasetController::class, 'showdataset'])->name('showdataset');
Route::get('/datasets/import', [DatasetController::class, 'showImportForm'])->name('datasets.import');
Route::post('/datasets/import', [DatasetController::class, 'import'])->name('datasets.import.store');
Route::get('/datasets/{id}/download', [DatasetController::class, 'download'])->name('datasets.download');
Route::middleware(['auth'])->group(function () {
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('analyses', [AnalysisController::class, 'store'])->name('analyses.store');
});







Route::get('/documentations-api', function () {

    return view('api-doc');
})->name('docs-api');
