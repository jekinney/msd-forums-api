<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepresenativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('represenatives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('fax');
            $table->string('address');
            $table->string('address_cont')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip');
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
        Schema::dropIfExists('represenatives');
    }
}
