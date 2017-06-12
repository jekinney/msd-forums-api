<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('toys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->index();
            $table->string('item_number', 60);
            $table->string('image')->nullable();
            $table->mediumText('description');
            $table->string('upc', 20);
            $table->string('msd')->nullable();
            $table->integer('case_qty');
            $table->integer('container_qty');
            $table->string('piece_cube', 10);
            $table->string('case_cude', 10);
            $table->integer('first_import_cost');
            $table->integer('duty');
            $table->integer('domestice_cost')->nullable();
            $table->integer('retail_price')->nullable();
            $table->string('recommended_ages');
            $table->boolean('is_import')->default(0);
            $table->boolean('trademark')->default(0);
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
        Schema::dropIfExists('toys');
    }
}
