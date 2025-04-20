<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comment_lead', function (Blueprint $table) {
            $table
                ->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_lead', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->dropForeign(['lead_id']);
        });
    }
};
