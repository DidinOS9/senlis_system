<?php

namespace App\Jobs;

use App\Models\Dataset;
use App\Models\Preprocessing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PreprocessingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataset;

    /**
     * Create a new job instance.
     *
     * @param Dataset $dataset
     */
    public function __construct(Dataset $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
{
    if (!is_array($this->dataset->normalized_text) || empty($this->dataset->normalized_text)) {
        return;
    }

    $batchSize = 500; // Tentukan ukuran batch
    $textChunks = array_chunk($this->dataset->normalized_text, $batchSize);

    // Variabel untuk menyimpan hasil batch
    $cleaning = [];
    $tokenizing = [];
    $stopword = [];
    $stemming = [];

    foreach ($textChunks as $chunk) {
        $data = [
            'text' => $chunk,
            'label' => array_slice($this->dataset->label, 0, count($chunk)),
        ];
        // dd($data);

        try {
            // Panggil Flask API untuk preprocessing pada setiap batch
            $response = Http::timeout(3600)
                ->withoutVerifying()
                ->post('http://127.0.0.1:5001/preprocess', $data);
            if ($response->successful()) {
                $result = $response->json();
                // dd($result);

                // Gabungkan hasil setiap batch ke dalam array
                $cleaning = array_merge($cleaning, $result['cleaning']);
                $tokenizing = array_merge($tokenizing, $result['tokenizing']);
                $stopword = array_merge($stopword, $result['stopword']);
                $stemming = array_merge($stemming, $result['stemming']);
                // dd($cleaning);
            } else {
                throw new \Exception('Preprocessing gagal pada batch: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Log::error('Error preprocessing: ' . $e->getMessage());
            return;
        }
    }
    // dd($result);
    // Setelah semua batch selesai, simpan hasil ke satu entri
    Preprocessing::updateOrCreate(
        ['dataset_id' => $this->dataset->id],
        [
            'cleaned_sentence' => json_encode($cleaning),
            'tokenized_sentence' => json_encode($tokenizing),
            'stopword_sentence' => json_encode($stopword),
            'stemmed_sentence' => json_encode($stemming),
        ]
    );
}


}
