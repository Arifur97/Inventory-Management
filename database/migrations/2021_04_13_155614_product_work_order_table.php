<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductWorkOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_work_order', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id');
            $table->string('sale_unit_id');
            $table->string('order_type');
            $table->intestringger('color');
            $table->string('size');
            $table->double('qty');
            $table->string('description');
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
        Schema::dropIfExists('product_work_order');
    }
}
