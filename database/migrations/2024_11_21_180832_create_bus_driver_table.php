<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bus_driver', function (Blueprint $table) {
            $table->foreignId('bu_id');
            $table->foreignId('driver_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bus_driver');
    }
};
