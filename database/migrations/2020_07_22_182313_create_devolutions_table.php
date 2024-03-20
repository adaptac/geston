<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolutions', function (Blueprint $table) {
            $table->id();
            $table->integer('id_users');
            $table->integer('id_products');
            $table->integer('id_clients');
            $table->double('payback');
            $table->integer('takenback_qty');
            $table->string('reference');
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
        Schema::dropIfExists('devolutions');
    }
}
