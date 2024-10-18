<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->char('slug',150);
            $table->char('model',150);
            $table->char('sku',100);
            $table->float('price');
            $table->float('special_price');
            $table->text('sort_description');
            $table->integer('sort_order');
            $table->integer('gst_id')->nullable();
            $table->char('name',250);
            $table->char('meta_title',250);
            $table->char('meta_keyword',250);
            $table->char('meta_description',250);
            $table->text('description');
            $table->Integer('is_feature')->default(0)->comment('0=feature, 1=non feature');
            $table->Integer('is_topsell')->default(0)->comment('0=topsell, 1=non topsell');
            $table->tinyInteger('status')->default(1)->comment('0=Active, 1=InActive');    
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
        Schema::dropIfExists('products');
    }
}
