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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('api_order_id')->default(-1);
            $table->string('channel_name')->nullable();
            $table->string('channel_id')->nullable();
            $table->integer('views')->default(0);
            $table->integer('views_done')->default(0);
            $table->integer('viewers_count')->default(0);
            $table->integer('join_delay')->default(0);
            $table->float('charge')->default(0);
            $table->float('formal_charge')->default(0);
            $table->float('profit')->default(0);
            $table->text('note')->nullable();
            $table->string('status')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid', 'refunded', 'canceled'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
