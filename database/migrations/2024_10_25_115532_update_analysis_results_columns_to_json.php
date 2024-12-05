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
        Schema::table('analysis_results', function (Blueprint $table) {
            $table->json('confussion_matrix_nb')->change();
            $table->json('confussion_matrix_svm')->change();
        });
    }

    public function down(): void
    {
        Schema::table('analysis_results', function (Blueprint $table) {
            $table->string('confussion_matrix_nb')->change();
            $table->string('confussion_matrix_svm')->change();
        });
    }

};
