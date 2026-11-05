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
        Schema::create('barbershopsimages', function (Blueprint $table) {
            $table->id();
            $table->string("path")->nullable();
            $table->boolean("is_primary")->default(0);
            $table->foreignId("barbershop_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barbershopsimages');
    }
};
