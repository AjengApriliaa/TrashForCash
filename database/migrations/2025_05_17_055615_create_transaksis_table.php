<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('layanan', ['antar', 'jemput']);
            $table->string('alamat'); // alamat user dari profile
            $table->string('lokasi'); // lokasi detail yang diinput
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->float('berat'); // dalam gram
            $table->date('tanggal');
            $table->integer('estimasi_koin');
            $table->string('bukti_foto')->nullable(); // path file foto
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('lokasi_antar')->nullable(); // khusus untuk tipe antar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
}