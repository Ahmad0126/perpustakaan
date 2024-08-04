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
        Schema::create('detail_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pinjaman')->nullable();
            $table->integer('id_buku');
            $table->date('tanggal_kembali')->nullable();
            $table->string('status', 50);
            $table->timestamps();
        });
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn('id_buku');
            $table->dropColumn('tanggal_kembali');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
