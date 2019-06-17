<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeriveFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('derive_filter', function (Blueprint $table) {
            $table->unsignedInteger('derive_id')->onDelete('cascade');
            $table->unsignedInteger('filter_id')->onDelete('cascade');

            $table->index(['derive_id', 'filter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('derive_filter');
    }
}
