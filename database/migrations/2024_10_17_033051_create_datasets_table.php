<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('datasets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('file_path'); 
            $table->string('status')->default('raw'); 
            $table->json('full_text');  
            $table->json('label')->nullable();  
            $table->string('word_cloud_path')->nullable();  
            $table->string('freq_chart_path')->nullable();  
            $table->string('confussion_matrix_path')->nullable();  
            $table->json('normalized_text')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasets');
    }
};
