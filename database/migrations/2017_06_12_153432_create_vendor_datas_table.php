<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->index();
            $table->string('terms');
            $table->string('full_container');
            $table->string('moq');
            $table->integer('defect');
            $table->string('defective_ded_by')->nullable();
            $table->string('shipping_port');
            $table->integer('coop_percent');
            $table->string('period');
            $table->string('ded_by');
            $table->integer('faa');
            $table->integer('ppd');
            $table->string('freight_comments')->nullable();
            $table->boolean('is_import')->default(0);
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
        Schema::dropIfExists('vendor_datas');
    }
}
