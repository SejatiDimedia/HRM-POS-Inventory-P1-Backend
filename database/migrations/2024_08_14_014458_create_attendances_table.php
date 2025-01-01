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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->date('date')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_leave')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leave_id')->nullable();
            $table->unsignedBigInteger('leave_type_id')->nullable();
            $table->unsignedBigInteger('holiday_id')->nullable();
            $table->dateTime('clock_in_date_time')->nullable();
            $table->dateTime('clock_out_date_time')->nullable();
            $table->integer('total_duration')->nullable();
            $table->boolean('is_late')->default(false);
            $table->boolean('is_half_day')->default(false);
            $table->boolean('is_paid')->default(false);
            $table->string('status')->default('present');
            $table->text('reason')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('leave_id')->references('id')->on('leaves');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            $table->foreign('holiday_id')->references('id')->on('holidays');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
