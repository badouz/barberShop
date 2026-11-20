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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string("phone",20)->nullable()->after("name");
            $table->string("city",20)->nullable()->after("phone");
            $table->string("address",250)->nullable()->after("city");
            $table->string("zip",20)->nullable()->after("address");
            $table->string("role",20)->nullable()->after("zip");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city', 'address', 'zip', 'role']);
        });
    }
};
