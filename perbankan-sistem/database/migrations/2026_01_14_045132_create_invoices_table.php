<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('Invoice_ID');
            $table->unsignedBigInteger('Vendor_ID'); // Kolom untuk foreign key
            $table->string('No_Referensi', 80);
            $table->date('Tanggal_Dokumen');
            $table->text('Deskripsi')->nullable();
            $table->decimal('Total_Tagihan', 15, 2);
            $table->timestamps();

            // Buat foreign key constraint
            $table->foreign('Vendor_ID')
                  ->references('Vendor_ID')
                  ->on('vendors')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};