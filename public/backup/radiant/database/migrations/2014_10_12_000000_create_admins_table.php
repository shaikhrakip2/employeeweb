<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->length(250);
            $table->string('email')->length(250)->unique();
            $table->string('mobile')->length(10)->unique();
            $table->string('image')->length(250)->nullable();
            $table->string('password')->length(250);
            $table->integer('role_id')->length(11)->unsigned();
            $table->rememberToken();
            $table->tinyInteger('status')->length(2)->default(1);            
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
        Schema::dropIfExists('admins');
    }
}
