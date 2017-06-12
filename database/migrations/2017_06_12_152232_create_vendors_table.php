<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('represenative_id')->nullable();
            $table->string('name');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('fax');
            $table->string('address');
            $table->string('address_cont')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('master_upc');
            $table->boolean('send_rep')->default(0);
            $table->boolean('consolidate')->default(0);
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
        Schema::dropIfExists('vendors');
    }
}
