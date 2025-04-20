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
        Schema::create('shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('deal_id');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('cost')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('defaultname')->nullable();
            $table->string('defaultphone')->nullable();
            $table->string('time')->nullable();
            $table->string('shipping_status')->default('new');
            $table->string('attempts')->default('1');
            $table->string('delivery_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shippings');
    }
};
