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
        //
        Schema::table('normalizations', function (Blueprint $table) {
            $table->json('kata_tidak_baku')->change();
            $table->json('kata_baku')->change();

            $table->string('name')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('norma;izations', function (Blueprint $table) {
            $table->string('kata_tidak_baku')->change();
            $table->string('kata_baku')->change();

            $table->dropColumn('name');
        });
    }
};
