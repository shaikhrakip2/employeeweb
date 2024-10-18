<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('setting_type')->length(2); 
            $table->string('setting_name')->length(250);
            $table->string('filed_label')->length(250);
            $table->string('filed_name')->length(250);
            $table->string('filed_type')->length(250);
            $table->text('filed_value');
            $table->string('field_options')->length(250);
            $table->tinyInteger('is_require')->length(2)->default(0);
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
        Schema::dropIfExists('general_settings');
    }
}
