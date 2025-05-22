<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('alamat')->nullable();
        $table->string('telepon')->nullable();
        $table->string('jenis_kelamin')->nullable();
        $table->date('tanggal_lahir')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['alamat', 'telepon', 'jenis_kelamin', 'tanggal_lahir']);
    });
}

};
