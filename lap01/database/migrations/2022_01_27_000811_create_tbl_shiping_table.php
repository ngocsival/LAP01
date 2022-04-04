<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblShipingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_shiping', function (Blueprint $table) {
            $table->id('shipping_id');
            $table->string('shipping_name');
            $table->integer('customer_id');
            $table->string('shipping_address');
            $table->string('shipping_email');
            $table->string('shipping_phone');
            $table->text('shipping_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_shiping');
    }
}
