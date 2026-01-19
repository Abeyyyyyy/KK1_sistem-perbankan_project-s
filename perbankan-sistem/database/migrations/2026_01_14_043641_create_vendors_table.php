<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id('Vendor_ID');
            $table->string('Nama_Vendor', 150);
            $table->string('Bank_Vendor', 100);
            $table->string('No_Rekening', 50);
            $table->string('NPWP', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
};