<?php

namespace App\Http\Controllers;

use App\Jobs\PreprocessingJob;
use App\Models\Dataset;
use App\Models\Preprocessing;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PreprocessingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua preprocessing data dan memuat relasi dataset
        $preprocessings = Preprocessing::with('dataset')->get();
        
        // Mengirimkan variabel preprocessings ke view
        return view('preprocessing.index', compact('preprocessings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $datasets = Dataset::all(); // Ambil semua dataset
        return view('preprocessing.create', compact('datasets'));
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    set_time_limit(0);
    $request->validate([
        'dataset' => 'required|exists:datasets,id',
    ]);

    $dataset = Dataset::findOrFail($request->input('dataset'));

    // Pastikan normalized_text sudah ada
    if (empty($dataset->normalized_text)) {
        return redirect()->back()->withErrors('Dataset belum memiliki teks yang dinormalisasi.');
    }

    // Dispatch job untuk menjalankan preprocessing secara asinkron
    PreprocessingJob::dispatch($dataset);

    return redirect()->route('preprocessing.index')->with('success', 'Preprocessing telah dimulai.');
}



    /**
     * Display the specified resource.
     */
    public function show(Preprocessing $preprocessing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preprocessing $preprocessing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preprocessing $preprocessing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preprocessing $preprocessing)
    {
        //
    }
}
