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
        Schema::create('renews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deal_id')->constrained('deals')->onDelete('cascade'); // Foreign key to deals table
            $table->string('deal_renew_id');
            $table->string('lead_id');
            $table->timestamp('renew_time');  // Timestamp for renew time
            $table->decimal('price', 10, 2);  // New cost as decimal
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renews');
    }
};
