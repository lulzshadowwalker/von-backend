<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passenger_trip', function (Blueprint $table) {
            $table->foreignId('passenger_id');
            $table->foreignId('trip_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passenger_trip');
    }
};
