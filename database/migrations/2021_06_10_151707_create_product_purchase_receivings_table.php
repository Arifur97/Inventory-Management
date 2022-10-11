<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchaseReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_purchase_receiving', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->integer('purchase_receiving_id');
            $table->integer('purchase_id');
            $table->integer('product_id');
            $table->integer('variant_id');
            $table->string('qty');
            $table->string('received')->nullable();
            $table->string('unit_id');
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
        Schema::dropIfExists('product_purchase_receiving');
    }
}
