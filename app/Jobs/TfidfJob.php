<?php
namespace App\Jobs;

use App\Models\Dataset;
use App\Models\TfidfWeight;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TfidfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dataset;

    public function __construct(Dataset $dataset)
    {
        $this->dataset = $dataset;
    }

    public function handle()
    {
        // Ambil data train dari dataset
        $train_data = json_decode($this->dataset->train_data, true);

        if (empty($train_data) || !isset($train_data['X_train'])) {
            Log::error('Training data is missing or invalid.');
            return;
        }

        $train_text = $train_data['X_train'];  // Mengambil teks training

        // Kirim request ke Flask API untuk menghitung TF-IDF
        $data = ['train_text' => $train_text];

        try {
            $response = Http::timeout(3000)->post('http://127.0.0.1:5001/tfidf', $data);
            
            if ($response->successful()) {
                $result = $response->json();
                
                // Simpan hasil TF-IDF ke dalam tabel `tfidfweights`
                TfidfWeight::updateOrCreate(
                    ['dataset_id' => $this->dataset->id],
                    ['dynamic_column' => json_encode($result)]
                );

                // Refresh cache setelah data diperbarui
                cache()->forget('tfidf_weights');

            } else {
                throw new \Exception('Failed to calculate TF-IDF: ' . $response->body());
            }

        } catch (\Exception $e) {
            Log::error('Error calculating TF-IDF: ' . $e->getMessage());
        }
    }
}
