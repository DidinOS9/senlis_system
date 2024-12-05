<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Normalization;
use Illuminate\Http\Request;

class NormalizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function normalize(Request $request)
    {
        // Validasi input
        $request->validate([
            'dataset' => 'required|exists:datasets,id',
            'dictionary' => 'required|exists:normalizations,id',
        ]);

        // Ambil dataset dan kamus
        $dataset = Dataset::findOrFail($request->input('dataset'));
        $dictionary = Normalization::findOrFail($request->input('dictionary'));

        // Ambil kata tidak baku dan kata baku dari kamus
        $kataTidakBaku = json_decode($dictionary->kata_tidak_baku, true);
        $kataBaku = json_decode($dictionary->kata_baku, true);

        // Buat array untuk menyimpan hasil normalisasi
        $normalizedText = [];
        $kataDiganti = [];
        $kataTidakBakuHash = [];

        // Proses setiap full_text dalam dataset
        foreach ($dataset->full_text as $text) {
            // Ganti kata tidak baku dengan kata baku menggunakan fungsi replaceTabooWords
            list($replacedText, $diganti, $hashes) = $this->replaceTabooWords($text, $kataTidakBaku, $kataBaku);
            
            // Simpan hasil
            $normalizedText[] = $replacedText;
            $kataDiganti = array_merge($kataDiganti, $diganti);
            $kataTidakBakuHash = array_merge($kataTidakBakuHash, $hashes);
        }

        // Simpan hasil normalisasi dan ubah status menjadi 'normalized'
        $dataset->normalized_text = $normalizedText;
        $dataset->status = 'normalized';
        $dataset->save();

        // Redirect ke halaman detail dataset
        return redirect()->route('datasets.show', $dataset->id)->with('success', 'Normalisasi berhasil dilakukan!');
    }


    public function replaceTabooWords($text, $kamusTidakBaku, $kamusBaku) {
        // Inisialisasi variabel untuk hasil
        $replaceWords = [];
        $kataDiganti = [];
        $kataTidakBakuHash = [];

        // Memastikan input adalah string
        if (is_string($text)) {
            // Pisahkan teks ke dalam kata-kata
            $words = explode(' ', $text);

            // Proses setiap kata dalam teks
            foreach ($words as $word) {
                // Jika kata ada di kamus kata tidak baku
                if (in_array($word, $kamusTidakBaku)) {
                    // Dapatkan index dari kata tidak baku
                    $index = array_search($word, $kamusTidakBaku);

                    // Dapatkan kata baku yang sesuai
                    $bakuWord = $kamusBaku[$index];

                    // Ganti kata tidak baku dengan kata baku
                    $replaceWords[] = $bakuWord;
                    $kataDiganti[] = $word;
                    $kataTidakBakuHash[] = hash('sha256', $word);  // Gunakan hash SHA-256 untuk kata
                } else {
                    // Jika kata tidak ada di kamus, simpan kata asli
                    $replaceWords[] = $word;
                }
            }

            // Gabungkan kata-kata yang diganti menjadi kalimat kembali
            $replacedText = implode(' ', $replaceWords);
        } else {
            // Jika input bukan string, kembalikan teks apa adanya
            $replacedText = $text;
        }

        // Kembalikan hasil normalisasi, kata yang diganti, dan hash kata tidak baku
        return [$replacedText, $kataDiganti, $kataTidakBakuHash];
    }




    public function upload() {
        return view('normalization.upload');
    }

    public function index()
    {
        //
        return view('normalization.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $dictionaries = Normalization::all(); // Ambil data kamus
        $dictionaryCount = $dictionaries->count(); // Hitung jumlah kamus
        $datasets = Dataset::all(); // Ambil data dataset
        return view('normalization.create', compact('dictionaries', 'dictionaryCount', 'datasets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    set_time_limit(0);
    // Validasi file yang diunggah
    $request->validate([
        'dictionary_file' => 'required|file|mimes:csv,xlsx,xls|max:2048',
        'name' => 'required|string|max:255',
    ]);

    // Baca file yang diunggah
    $file = $request->file('dictionary_file');
    $fileContent = \Maatwebsite\Excel\Facades\Excel::toArray([], $file);

    // Inisialisasi arrays untuk menyimpan kata tidak baku dan kata baku
    $kataTidakBaku = [];
    $kataBaku = [];

    // Pastikan file memiliki kolom yang benar
    $header = $fileContent[0][0]; // Baris pertama digunakan sebagai header
    if (isset($header[0]) && $header[0] === 'kata_tidak_baku' && isset($header[1]) && $header[1] === 'kata_baku') {
        // Iterasi mulai dari baris kedua (data)
        foreach (array_slice($fileContent[0], 1) as $row) {
            if (isset($row[0]) && isset($row[1])) {
                $kataTidakBaku[] = $row[0]; // Ambil kata tidak baku dari kolom pertama
                $kataBaku[] = $row[1]; // Ambil kata baku dari kolom kedua
            } else {
                return redirect()->back()->withErrors(['error' => 'Beberapa baris dalam file tidak memiliki data kata tidak baku atau kata baku.']);
            }
        }
    } else {
        return redirect()->back()->withErrors(['error' => 'File CSV/XLSX tidak memiliki format yang benar. Kolom harus bernama "kata_tidak_baku" dan "kata_baku".']);
    }

    // Simpan ke database
    Normalization::create([
        'name' => $request->input('name'),
        'kata_tidak_baku' => json_encode($kataTidakBaku),
        'kata_baku' => json_encode($kataBaku),
    ]);

    return redirect()->route('normalization.create')->with('success', 'Kamus berhasil diunggah!');
}


    /**
     * Display the specified resource.
     */
    public function show(Normalization $normalization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Normalization $normalization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Normalization $normalization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $normalization = Normalization::findOrFail($id);
        $normalization->delete();

        return redirect()->route('normalization.create')->with('success', 'Dictionary deleted successfully');
    }
}
