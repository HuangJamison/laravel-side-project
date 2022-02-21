<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('content', 20);
            $table->string('assigner', 25);
            $table->date('deadline');
            $table->tinyInteger('is_completed')->default(0);
            $table->dateTime('completed_at')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->softDeletes()->nullable();
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
        Schema::dropIfExists('todos');
    }
}
