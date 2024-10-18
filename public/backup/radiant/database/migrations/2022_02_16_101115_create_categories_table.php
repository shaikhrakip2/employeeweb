<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->length(100)->nullable();
            $table->Integer('parent_id')->length(11);
            $table->string('name')->length(250);
            $table->text('description');
            $table->string('meta_title')->length(250);
            $table->string('meta_keyword')->length(250);
            $table->string('meta_description')->length(250);
            $table->Integer('is_feature')->length(2)->default(0)->comment('0=feature, 1=non feature');
            $table->string('image')->length(250);
            $table->Integer('sort_order')->length(10);   
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
      Schema::dropIfExists('categories');
    }
}
