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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('thumbnail');
            $table->boolean('is_public')->default(false);
            $table->enum('type', ['painting', 'sculpture', 'statues', 'fossils', 'handicrafts', 'others']);
            $table->json('images');
            $table->decimal('price', 10, 2);
            $table->string('slug');
            $table->integer('quantity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
