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
        Schema::table('datasets', function (Blueprint $table) {
            $table->string('tfidf_path')->nullable()->after('confussion_matrix_path');
            $table->string('model_path_nb')->nullable()->after('tfidf_path');  
            $table->string('model_path_svm')->nullable()->after('model_path_nb');  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datasets', function (Blueprint $table) {
            //
            $table->dropColumn(['tfidf_path', 'model_path_nb', 'model_path_svm']);
        });
    }
};
