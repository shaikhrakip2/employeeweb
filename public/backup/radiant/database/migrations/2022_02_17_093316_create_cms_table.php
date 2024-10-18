<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->length(100)->nullable();
            $table->string('name')->length(250);
            $table->string('cms_title')->length(250);
            $table->string('meta_title')->length(250);
            $table->string('meta_keyword')->length(250);
            $table->string('meta_description')->length(250);
            $table->text('cms_contant');
            $table->string('image')->length(250);
            $table->tinyInteger('status')->length(2)->default(1)->comment('0=Active, 1=InActive'); 
            $table->softDeletes();         
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
        Schema::dropIfExists('cms');
    }
}
