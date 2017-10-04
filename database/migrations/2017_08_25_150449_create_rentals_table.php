<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('rentable_id')->unsigned();
            $table->string('rentable_type');
            $table->dateTime('checkout_date');
            $table->dateTime('due_date');
            $table->dateTime('return_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'rentable_id', 'rentable_type']);

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
