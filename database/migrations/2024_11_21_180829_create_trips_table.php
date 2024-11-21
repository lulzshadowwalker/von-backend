<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->dateTime('departured_at')->nullable();
            $table->dateTime('arrived_at')->nullable();
            $table->foreignId('driver_id');
            $table->foreignId('bus_id');
            $table->foreignId('route_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
