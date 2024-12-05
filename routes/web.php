<?php

use App\Http\Controllers\AnalysisResultController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\NormalizationController;
use App\Http\Controllers\PreprocessingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TfidfweightController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('datasets/labelling', [DatasetController::class, 'labelling'])->name('datasets.labelling');
    Route::resource('datasets', DatasetController::class);

    Route::get('normalization', [NormalizationController::class, 'index'])->name('normalization.index');
    Route::get('normalization/create', [NormalizationController::class, 'create'])->name('normalization.create');
    Route::get('normalization/upload', [NormalizationController::class, 'upload'])->name('normalization.upload');
    Route::post('normalization/store', [NormalizationController::class, 'store'])->name('normalization.store');
    Route::post('normalization/normalize', [NormalizationController::class, 'normalize'])->name('normalization.normalize');
    Route::delete('normalization/{id}', [NormalizationController::class, 'destroy'])->name('normalization.destroy');

    Route::resource('preprocessing', PreprocessingController::class);

    Route::resource('tfidf', TfidfweightController::class);
    Route::get('tfidf/{id}', [TfidfweightController::class, 'show'])->name('tfidf.show');
    Route::post('tfidf/split', [TfidfweightController::class, 'split'])->name('tfidf.split');


    Route::get('analyze-text', [AnalysisResultController::class, 'analyze'])->name('analyze');
    Route::post('analyze-text/analyze', [AnalysisResultController::class, 'analyze_text'])->name('analyze_text');

    Route::resource('analysis_result', AnalysisResultController::class);



});

require __DIR__.'/auth.php';
