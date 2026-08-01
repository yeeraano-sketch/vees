<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('providers', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->string('full_name');

            $table->string('phone')->unique();

            $table->string('city');

            $table->string('work_mode');

            $table->string('status');

            $table->string('availability');

            $table->boolean('verified');

            $table->json('settings')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
