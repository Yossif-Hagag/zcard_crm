<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRejectShippingReasonShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reject_shipping_reason_shipping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reject_shipping_reason_id');
            $table->foreignId('shipping_id');
            $table->text('other')->nullable();
            $table->timestamps();
        });

        Schema::table('reject_shipping_reason_shipping', function (Blueprint $table) {
            $table->foreign('reject_shipping_reason_id', 'rsrs_rsr_id_fk')
                  ->references('id')->on('reject_shipping_reasons')
                  ->onDelete('cascade');

            $table->foreign('shipping_id', 'rsrs_shipping_id_fk')
                  ->references('id')->on('shippings')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reject_shipping_reason_shipping', function (Blueprint $table) {
            $table->dropForeign(['reject_shipping_reason_id']);
            $table->dropForeign(['shipping_id']);
        });

        Schema::dropIfExists('reject_shipping_reason_shipping');
    }
}
