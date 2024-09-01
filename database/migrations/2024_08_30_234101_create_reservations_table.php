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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->string('table_number'); 
            $table->integer('guests');
            $table->string('status');
            $table->string('name');
            $table->string('email');
            $table->string('contact');
            $table->date('date');
            $table->integer('tickets')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('screenshot')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
