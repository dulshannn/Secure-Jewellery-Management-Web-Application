<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('username', 20)->unique();
            $table->string('email')->unique();
            $table->string('phone', 15);
            $table->string('password');
            $table->enum('role', ['Admin', 'Manager', 'Supplier', 'Customer'])->default('Customer');
            $table->boolean('is_active')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('username');
            $table->index('email');
            $table->index('role');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
