<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->enum('payment_status', ['pending', 'paid', 'canceled'])->default('pending');
            $table->string('payment_url')->nullable();
            $table->string('payment_token')->nullable();
            $table->decimal('payment_value', 10, 2)->default(0);
            $table->date('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
