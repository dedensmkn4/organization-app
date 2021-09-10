<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableName::TABLE_ORGANIZATION, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(\App\Constant\Fields\OrganizationField::ACCOUNT_MANAGER_ID)->nullable();
            $table->string(\App\Constant\Fields\OrganizationField::NAME,100);
            $table->string(\App\Constant\Fields\OrganizationField::EMAIL,100);
            $table->string(\App\Constant\Fields\OrganizationField::PHONE,20);
            $table->string(\App\Constant\Fields\OrganizationField::WEBSITE);
            $table->string(\App\Constant\Fields\OrganizationField::LOGO);
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
        Schema::dropIfExists(\App\Constant\TableName::TABLE_ORGANIZATION);
    }
}
