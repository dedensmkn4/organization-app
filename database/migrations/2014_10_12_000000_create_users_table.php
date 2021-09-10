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
            $table->string(\App\Constant\Fields\UserField::NAME);
            $table->string(\App\Constant\Fields\UserField::EMAIL)->unique();
            $table->timestamp(\App\Constant\Fields\UserField::EMAIL_VERIFIED_AT)->nullable();
            $table->string(\App\Constant\Fields\UserField::PASSWORD);
            $table->string(\App\Constant\Fields\UserField::USER_TYPE);
            $table->rememberToken();
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
