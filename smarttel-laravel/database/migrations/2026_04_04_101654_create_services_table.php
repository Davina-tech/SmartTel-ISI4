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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('phone_service');
            $table->string('multiple_lines');
            $table->string('internet_service');
            $table->string('online_security');
            $table->string('online_backup');
            $table->string('device_protection');
            $table->string('tech_support');
            $table->string('streaming_tv');
            $table->string('streaming_movies');
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('customer_id')
                  ->on('customers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};