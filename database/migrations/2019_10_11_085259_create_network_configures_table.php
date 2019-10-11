<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetworkConfiguresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('network_configures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('network_id');
            $table->unsignedBigInteger('container_id');
            $table->unsignedInteger('endpoint_port');
            $table->unsignedInteger('dport');
            $table->timestamps();

            $table->foreign('network_id')->references('id')->on('networks');
            $table->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('network_configures');
    }
}
