<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id('Item_ID');
            $table->unsignedBigInteger('Invoice_ID');
            $table->string('Nama_Item', 200);
            $table->decimal('Nominal', 15, 2);
            $table->string('Cost_Center', 50);
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
        Schema::dropIfExists('items');
    }
};