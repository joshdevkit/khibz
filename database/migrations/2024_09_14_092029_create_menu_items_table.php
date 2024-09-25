<?php

// 2024_09_14_072513_create_menu_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key to categories table
            $table->string('name'); // Name of the menu item
            $table->decimal('price', 8, 2); // Price of the menu item
            $table->string('image')->nullable(); // Path to the image file
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};


