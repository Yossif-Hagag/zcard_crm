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
        Schema::create('print_cards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('print_id');
            $table->unsignedBigInteger('deal_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('card_name')->nullable();
            $table->string('card_code')->nullable();
            $table->string('print_status')->default('pending');
            $table->string('send_status')->default('send');
            $table->string('confirm_status')->nullable();
            $table->text('confirm_reason')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('print_id')->references('id')->on('printings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_cards');
    }
};
