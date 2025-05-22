<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('layanan'); // antar / jemput
            $table->string('lokasi');  // lokasi teks
            $table->decimal('latitude', 10, 7)->nullable();   // contoh: -6.1234567
            $table->decimal('longitude', 10, 7)->nullable();  // contoh: 106.1234567
            $table->float('berat');
            $table->string('bukti_foto')->nullable(); // nama file gambar
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}
