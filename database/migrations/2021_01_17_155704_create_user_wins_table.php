<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_wins', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->integer('type');
            $table->integer('status');
            $table->bigInteger('user_id');
            $table->bigInteger('draw_id');
            $table->bigInteger('lot_id')->nullable();
            $table->integer('count');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('draw_id')->references('id')->on('draws');
            $table->foreign('lot_id')->references('id')->on('lots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wins');
    }
}
