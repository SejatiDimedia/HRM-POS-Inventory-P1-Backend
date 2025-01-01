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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->double('basic_salary'); // Nilai gaji pokok dari tabel basic_salaries
            $table->double('salary_amount');
            $table->double('net_salary');
            $table->double('total_days', 8, 2);
            $table->double('working_days', 8, 2);
            $table->double('present_days', 8, 2);
            $table->integer('total_office_time');
            $table->integer('total_worked_time');
            $table->integer('half_days');
            $table->double('late_days', 8, 2);
            $table->double('paid_leaves', 8, 2);
            $table->double('unpaid_leaves', 8, 2);
            $table->double('holiday_count', 8, 2);
            $table->date('payment_date')->nullable();
            $table->string('status')->default('generated');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
