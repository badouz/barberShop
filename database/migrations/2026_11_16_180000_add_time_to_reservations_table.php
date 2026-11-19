<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->time('time')->nullable()->after('dateReservation');
            $table->unique(['barbermans_id', 'dateReservation', 'time']);
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropUnique('reservations_barbermans_id_datereservation_time_unique');
            $table->dropColumn('time');
        });
    }
};
