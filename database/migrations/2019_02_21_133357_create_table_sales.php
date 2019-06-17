<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->string('order_name', 10);
            $table->string('shop_name', 40);
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('derive_id');
            $table->integer('quantity');
            $table->timestamps();

            $table->primary(['order_name', 'shop_name', 'derive_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
