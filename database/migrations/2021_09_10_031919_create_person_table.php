<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableName::TABLE_PERSON, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(\App\Constant\Fields\PersonField::ORGANIZATION_ID);
            $table->string(\App\Constant\Fields\PersonField::NAME, 100);
            $table->string(\App\Constant\Fields\PersonField::EMAIL);
            $table->string(\App\Constant\Fields\PersonField::PHONE,30);
            $table->string(\App\Constant\Fields\PersonField::AVATAR);
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
        Schema::dropIfExists(\App\Constant\TableName::TABLE_PERSON);
    }
}
