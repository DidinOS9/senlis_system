<?php

namespace App\Http\Controllers;

use App\Jobs\TfidfJob;
use App\Models\Dataset;
use App\Models\Preprocessing;
use App\Models\Tfidfweight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TfidfweightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index()
    {
        set_time_limit(0);

        // Gunakan cache untuk menyimpan data TF-IDF selama 60 menit, tanpa decoding
        $tfidf_weights = cache()->remember('tfidf_weights', now()->addMinutes(60), function () {
            return TfidfWeight::with('dataset')->paginate(10);
        });

        return view('tfidf.index', compact('tfidf_weights'));
    }


    public function create()
    {
        $datasets = Dataset::all();
        return view('tfidf.create', compact('datasets'));
    }

    public function split(Request $request)
{
    $request->validate([
        'dataset' => 'required|exists:datasets,id',
        'test_size' => 'required|numeric|min:5|max:50',
    ]);

    $dataset = Dataset::findOrFail($request->dataset);
    $preprocessing = Preprocessing::where('dataset_id', $dataset->id)->first();

    if (empty($preprocessing)) {
        return redirect()->back()->withErrors('Dataset belum memiliki data preprocessing.');
    }

    // Cek apakah data sudah dalam bentuk array atau masih berupa JSON string
    $stemmed_text = is_string($preprocessing->stemmed_sentence) 
        ? json_decode($preprocessing->stemmed_sentence, true) 
        : $preprocessing->stemmed_sentence;

    $labels = is_string($dataset->label) 
        ? json_decode($dataset->label, true) 
        : $dataset->label;


    if (empty($stemmed_text) || empty($labels)) {
        return redirect()->back()->withErrors('Data stemmed atau label kosong.');
    }

    // Rasio data uji
    $test_size = $request->test_size / 100;

    // Split data menggunakan Flask API
    $response = Http::post('http://127.0.0.1:5001/split', [
        'text' => $stemmed_text,
        'labels' => $labels,
        'test_size' => $test_size,
    ]);

    if ($response->successful()) {
        $split_data = $response->json();

        // Simpan data train dan test ke dalam tabel datasets
        $dataset->train_data = json_encode([
            'X_train' => $split_data['X_train'],
            'y_train' => $split_data['y_train'],
        ]);

        $dataset->test_data = json_encode([
            'X_test' => $split_data['X_test'],
            'y_test' => $split_data['y_test'],
        ]);

        $dataset->status = 'split';
        $dataset->save();

        return redirect()->route('tfidf.create')->with('success', 'Split data berhasil dilakukan.');
    } else {
        return redirect()->back()->withErrors('Gagal melakukan split data.');
    }
}


     public function store(Request $request)
    {
        set_time_limit(0);
        
        $request->validate([
            'dataset' => 'required|exists:datasets,id',
        ]);

        $dataset = Dataset::findOrFail($request->dataset);

        // Periksa apakah split data tersedia
        if (empty($dataset->train_data) || empty($dataset->test_data)) {
            return redirect()->back()->withErrors('Data split belum tersedia. Lakukan split data terlebih dahulu.');
        }

        // Hapus cache lama sebelum dispatching job
        cache()->forget('tfidf_weights');

        // Dispatch job untuk menghitung TF-IDF menggunakan data training
        TfidfJob::dispatch($dataset);

        return redirect()->route('tfidf.index')->with('success', 'Proses perhitungan TF-IDF dimulai.');
    }





    /**
     * Display the specified resource.
     */
     public function show($id)
    {
        set_time_limit(0);
        
        // Gunakan cache untuk menyimpan data TF-IDF berdasarkan ID selama 60 menit
        $tfidf_weight = cache()->remember("tfidf_weight_{$id}", now()->addMinutes(60), function () use ($id) {
            return TfidfWeight::with('dataset')->findOrFail($id);
        });

        // Decode dynamic_column untuk menampilkan data TF-IDF
        $dataset = $tfidf_weight->dataset;
        $tfidf_weights = json_decode($tfidf_weight->dynamic_column, true);

        return view('tfidf.show', compact('dataset', 'tfidf_weights'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tfidfweight $tfidfweight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tfidfweight $tfidfweight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tfidfweight $tfidfweight)
    {
        //
    }
}
