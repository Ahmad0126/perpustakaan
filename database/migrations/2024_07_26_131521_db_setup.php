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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username', 25);
            $table->string('password', 60);
            $table->enum('level', ['Admin','Petugas']);
            $table->string('nama', 60);
            $table->timestamps();
        });
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_member', 25);
            $table->string('nama', 60);
            $table->date('tanggal_lahir');
            $table->string('alamat', 200);
            $table->string('pendidikan', 20)->nullable();
            $table->string('pekerjaan', 20)->nullable();
            $table->timestamps();
        });
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->integer('id_member');
            $table->integer('id_buku');
            $table->date('tanggal_dipinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();
        });
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_buku', 25);
            $table->string('judul', 128);
            $table->string('penulis', 60);
            $table->string('penerbit', 60);
            $table->integer('id_kategori')->nullable();
            $table->integer('jumlah')->nullable();
            $table->date('tanggal_rilis');
            $table->timestamps();
        });
        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rak', 25);
            $table->string('nama', 60);
            $table->timestamps();
        });
        Schema::create('pengunjung_member', function (Blueprint $table) {
            $table->id();
            $table->integer('id_member');
            $table->date('tanggal');
            $table->timestamps();
        });
        Schema::create('pengunjung_umum', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama', 60);
            $table->string('alamat', 200);
            $table->date('tanggal_lahir');
            $table->string('pendidikan', 20)->nullable();
            $table->string('pekerjaan', 20)->nullable();
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
