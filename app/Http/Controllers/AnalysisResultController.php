<?php

namespace App\Http\Controllers;

use App\Models\AnalysisResult;
use App\Models\Dataset;
use App\Models\Preprocessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalysisResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function analyze() {
        $datasets = Dataset::all();
        return view('analyst_result.analyze', compact('datasets'));
    }

public function analyze_text(Request $request)
{
    $request->validate([
        'dataset_id' => 'required|exists:datasets,id',
        'text_input' => 'required|string',
        'method' => 'required|in:naive_bayes,svm',
    ]);

    $dataset = Dataset::findOrFail($request->dataset_id);
    $text = $request->text_input;
    $method = $request->method;

    // Save inputs in the session for persistence
    session([
        'dataset_id' => $dataset->id,
        'text_input' => $text,
        'method' => $method,
    ]);

    // Define model paths
    $tfidf_path = storage_path("app/public/{$dataset->tfidf_path}");
    $model_path = $method === 'naive_bayes' 
                    ? storage_path("app/public/{$dataset->model_path_nb}") 
                    : storage_path("app/public/{$dataset->model_path_svm}");

    // Send request to the Flask server for analysis
    $response = Http::post('http://127.0.0.1:5001/predict', [
        'text' => $text,
        'tfidf_path' => $tfidf_path,
        'model_path' => $model_path,
    ]);

    if (!$response->successful()) {
        return redirect()->back()->withErrors('Failed to analyze sentiment.');
    }

    $result = $response->json();
    $sentiment = $result['sentiment'] ?? 'Unknown';

    // Store the result in session and redirect back
    return redirect()->back()->with('analysis_result', $sentiment);
}


    public function index()
    {
        //
        $analysis_results = AnalysisResult::with('dataset')->get();
        return view('analyst_result.index', compact('analysis_results'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $datasets = Dataset::all();

        return view('analyst_result.create', compact('datasets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    set_time_limit(0);
    $request->validate([
        'dataset_id' => 'required|exists:datasets,id',
    ]);

    $dataset = Dataset::findOrFail($request->dataset_id);
    
    // Retrieve split data (train/test) from the dataset
    $train_data = json_decode($dataset->train_data, true);
    $test_data = json_decode($dataset->test_data, true);

    if (empty($train_data) || empty($test_data)) {
        return redirect()->back()->withErrors('Data split belum tersedia.');
    }

    // Extract train and test text and labels
    $train_text = $train_data['X_train'];
    $train_labels = $train_data['y_train'];
    $test_text = $test_data['X_test'];
    $test_labels = $test_data['y_test'];

    // Send data to the analysis endpoint
    $response = Http::post('http://127.0.0.1:5001/analyze', [
        'train_text' => $train_text,
        'train_labels' => $train_labels,
        'test_text' => $test_text,
        'test_labels' => $test_labels,
        'dataset_id' => $dataset->id,
    ]);

    if (!$response->successful()) {
        return redirect()->back()->withErrors('Gagal melakukan analisis.');
    }

    $result = $response->json();

    // Update paths and model storage paths in the dataset table
    $dataset->update([
        'confussion_matrix_path' => json_encode([
            'nb' => $result['nb_conf_matrix_path'],
            'svm' => $result['svm_conf_matrix_path']
        ]),
        'freq_chart_path' => $result['freq_chart_path'], 
        'word_cloud_path' => $result['word_cloud_path'],
        'tfidf_path' => $result['tfidf_path'],
        'model_path_nb' => $result['model_path_nb'],
        'model_path_svm' => $result['model_path_svm']
    ]);

    // Store analysis results in analysis_results table
    AnalysisResult::updateOrCreate(
        ['dataset_id' => $dataset->id],
        [
            'method_nb' => json_encode(['accuracy' => $result['nb_accuracy']]),
            'method_svm' => json_encode(['accuracy' => $result['svm_accuracy']]),
            'confussion_matrix_nb' => json_encode($result['nb_classification_report']),
            'confussion_matrix_svm' => json_encode($result['svm_classification_report']),
        ]
    );

    return redirect()->route('analysis_result.index')->with('success', 'Analisis berhasil disimpan.');
}




    /**
     * Display the specified resource.
     */
    public function show(AnalysisResult $analysisResult)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnalysisResult $analysisResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnalysisResult $analysisResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnalysisResult $analysisResult)
    {
        //
    }
}
