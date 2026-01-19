<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('Pembayaran_ID');
            $table->unsignedBigInteger('Invoice_ID');
            $table->string('Metode_Pembayaran', 80);
            $table->date('Tanggal_Bayar');
            $table->decimal('Total_Bayar', 15, 2);
            $table->string('Rekening_Tujuan', 80);
            $table->timestamps();

            $table->foreign('Invoice_ID')
                  ->references('Invoice_ID')
                  ->on('invoices')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};