<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->length(100);
            $table->tinyInteger('type')->length(2)->default(1)->comment('1=Photo Gallery, 2=Video Gallery');
            $table->string('name')->length(250);
            $table->text('description');
            $table->integer('sort_order')->length(10);
            $table->string('image')->length(250);
            $table->tinyInteger('status')->length(2)->default(1)->comment('0=Active, 1=InActive'); 
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
        Schema::dropIfExists('galleries');
    }
}
