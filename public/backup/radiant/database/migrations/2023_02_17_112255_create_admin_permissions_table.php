<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->length(11);
            $table->integer('module_id')->length(11);
            $table->tinyInteger('can_add')->length(2)->default(0);
            $table->tinyInteger('can_edit')->length(2)->default(0);
            $table->tinyInteger('can_view')->length(2)->default(0);
            $table->tinyInteger('can_delete')->length(2)->default(0);
            $table->tinyInteger('allow_all')->length(2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
