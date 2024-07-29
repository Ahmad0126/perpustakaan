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
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->string('status', 50);
        });
        Schema::table('member', function (Blueprint $table) {
            $table->string('email');
            $table->string('password');
        });
        Schema::create('koleksi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_buku');
            $table->timestamps();
        });
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_buku');
            $table->text('ulasan');
            $table->integer('rating');
            $table->timestamps();
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
