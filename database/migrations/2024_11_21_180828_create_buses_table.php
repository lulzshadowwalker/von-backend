<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("buses", function (Blueprint $table) {
            $table->id();
            $table->string("license_plate")->unique();
            $table->integer("capacity");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("buses");
    }
};
