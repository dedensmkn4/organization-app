<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountManagerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableName::TABLE_ACCOUNT_MANAGER, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(\App\Constant\Fields\AccountManagerField::ACCOUNT_MANAGER_USER_ID);
            $table->string(\App\Constant\Fields\AccountManagerField::FULL_NAME,100);
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
        Schema::dropIfExists(\App\Constant\TableName::TABLE_ACCOUNT_MANAGER);
    }
}
