<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_orders ', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no');
            $table->string('sale_id');
            $table->integer('customer_id');
            $table->integer('warehouse_id');
            $table->string('priority');
            $table->string('expected_date');
            $table->string('date');
            $table->string('stage');
            $table->integer('user_id');
            $table->double('item');
            $table->string('document')->nullable();
            $table->string('work_order_status')->nullable();
            $table->integer('send_to')->nullable();
            $table->integer('work_order_note')->nullable();
            $table->integer('staff_note')->nullable();
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
        Schema::dropIfExists('work_orders');
    }
}
