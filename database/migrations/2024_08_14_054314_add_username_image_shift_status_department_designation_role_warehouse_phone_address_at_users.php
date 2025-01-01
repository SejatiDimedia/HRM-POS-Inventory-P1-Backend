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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->boolean('is_superadmin')->default(0);
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->string('user_type')->default('employee');
            // $table->boolean('is_walkin_customer')->default(0);
            $table->boolean('login_enabled')->default(1);
            $table->string('profile_image')->nullable();
            $table->string('status')->default('Enable');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            //$table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('shift_id')->nullable();

            // Foreign key constraints
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            //$table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('set null');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('profile_image');
            $table->dropColumn('status');
            $table->dropColumn('warehouse_id');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('shift_id');
            $table->dropColumn('department_id');
            $table->dropColumn('designation_id');
            $table->dropColumn('role_id');
            //$table->dropColumn('created_by');
            $table->dropColumn('is_superadmin');
            $table->dropColumn('user_type');
            $table->dropColumn('login_enabled');
            $table->dropColumn('company_id');

        });
    }
};
