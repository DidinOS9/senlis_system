<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function labelling()
    {
        
        return view('datasets.labelling');
    }

    public function index()
    {
        //
        $datasets = Dataset::all();
        return view('datasets.index', compact('datasets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('datasets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi input form
        $request->validate([
            'name' => 'required|string|max:255',
            'dataset' => 'required|file|mimes:csv,xlsx|max:2048',
        ]);

        //Simpan file dataset
        $file = $request->file('dataset');
        $filePath = $file->store('datasets', 'public');

        //Baca file csv/xlsx dan simpan dalam array
        $fileContent = Excel::toArray([], $file);
        // dd($fileContent[0][0]);

        // Pastikan data terbaca
        if (empty($fileContent) || !isset($fileContent[0])) {
            return redirect()->back()->withErrors(['error' => 'File tidak berisi data yang valid.']);
        }

        //Inisialisasi data full_text, label, dan normalized
        $fullText = [];
        $label = [];

        // Lewati baris pertama (header)
        foreach (array_slice($fileContent[0], 1) as $row) {
            if (isset($row[2]) && isset($row[1])) {
                $fullText[] = $row[2]; // Ambil full_text
                $label[] = $row[1]; // Ambil label
            } else {
                return redirect()->back()->withErrors(['error' => 'Kolom full_text atau label tidak ditemukan dalam file.']);
            }
        }

        //Simpan data ke database
        $dataset = Dataset::create([
            'name' => $request->input('name'),
            'file_path' => $filePath,
            'full_text' => $fullText,
            'label' => $label,
            'status' => count($label) > 0 ? 'labeled' : 'raw'
        ]);

        return redirect()->route('datasets.index')->with('success', 'Dataset berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dataset $dataset)
    {
        //
        set_time_limit(0);
        return view('datasets.show', compact('dataset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dataset $dataset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dataset $dataset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dataset $dataset)
    {
        //
        DB::beginTransaction();

        try {
            // Hapus data preprocessing terkait dataset
            $dataset->preprocessings()->delete();
            
            // Hapus data tfidf terkait dataset
            $dataset->tfidfWeights()->delete();
            
            // Hapus data analys result terkait dataset
            $dataset->analysisResult()->delete();

            if (!is_null($dataset->file_path) && trim($dataset->file_path) !== '' && Storage::exists($dataset->file_path)) {
                Storage::delete($dataset->file_path); // Hapus file dari storage
            }

            $dataset->delete();

            DB::commit();
            return redirect()->route('datasets.index')->with('success', 'Dataset berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('datasets.index')->withErrors(['error' => 'Terjadi kesalahan saat menghapus dataset.']);
        }
    }
}
