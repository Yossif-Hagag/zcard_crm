<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shipping_delay', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id'); // Foreign key to deal table
            $table->foreignId('shipping_id')->constrained()->onDelete('cascade'); // Foreign key to deal table
            $table->date('date')->default(now());
            $table->string('reason'); // Use string type for reason
            $table->time('time'); // Use time type for time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shipping_delay');
    }
};
