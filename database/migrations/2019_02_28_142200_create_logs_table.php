<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('error')->nullable();
            $table->boolean('success')->nullable();
            $table->string('shop_name')->nullable();
            $table->integer('derive_id')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('stock_prestashop')->nullable();
            $table->string('stock_change_prestashop')->nullable();
            $table->string('message')->nullable();
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
        Schema::dropIfExists('logs');
    }
}
