<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->integer('currency_fund')->nullable();
            $table->integer('currency_random_from')->nullable();
            $table->integer('currency_random_to')->nullable();
            $table->integer('score_random_from')->nullable();
            $table->integer('score_random_to')->nullable();
            $table->integer('currency_slot_count')->nullable();
            $table->integer('score_slot_count')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('draws');
    }
}
