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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('shift_name');
            $table->time('clock_in_time');
            $table->time('clock_out_time');
            $table->integer('late_mark_after'); // minutes
            $table->integer('early_clock_in_time'); // minutes
            $table->integer('allow_clock_out_till'); // minutes
            $table->boolean('self_clocking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
