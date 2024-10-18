<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->length(250);
            $table->string('email')->length(250)->unique();
            $table->string('mobile')->length(10)->unique();
            $table->string('image')->length(250)->nullable();
            $table->string('device_id')->length(250)->nullable();
            $table->string('fcm_id')->length(250)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->length(250);
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
        Schema::dropIfExists('users');
    }
}
