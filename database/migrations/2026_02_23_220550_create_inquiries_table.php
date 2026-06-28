<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['general', 'product', 'service']);
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->enum('status', ['new', 'in_progress', 'replied', 'archived'])->default('new');
            $table->timestamps();

            $table->index(['status', 'type']);
            $table->index(['email', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
