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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->string('module_name')->nullable();
            // $table->enum('feature', ['shift', 'department', 'designations', 'leaves', 'payroll', 'holiday', 'attendance']);
            // $table->boolean('view')->default(false);
            // $table->boolean('add')->default(false);
            // $table->boolean('edit')->default(false);
            // $table->boolean('delete')->default(false);
            // $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
