<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->id('Petugas_ID');
            $table->string('Nama_Petugas', 150);
            $table->string('Jabatan_Pegawai', 100);
            $table->string('Divisi_Pegawai', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('petugas');
    }
};