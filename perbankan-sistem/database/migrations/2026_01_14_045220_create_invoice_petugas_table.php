<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_petugas', function (Blueprint $table) {
            $table->unsignedBigInteger('Invoice_ID');
            $table->unsignedBigInteger('Petugas_ID');
            $table->string('Peran', 80);
            
            $table->primary(['Invoice_ID', 'Petugas_ID']);
            
            $table->foreign('Invoice_ID')
                  ->references('Invoice_ID')
                  ->on('invoices')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
                  
            $table->foreign('Petugas_ID')
                  ->references('Petugas_ID')
                  ->on('petugas')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_petugas');
    }
};