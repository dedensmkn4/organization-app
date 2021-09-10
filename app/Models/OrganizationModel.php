<?php

namespace App\Models;

use App\Constant\Fields\OrganizationField;
use App\Constant\Fields\PersonField;
use App\Constant\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationModel extends Model
{
    use SoftDeletes;

    protected $table    = TableName::TABLE_ORGANIZATION;
    protected $fillable = [
        OrganizationField::ACCOUNT_MANAGER_ID,
        OrganizationField::NAME,
        OrganizationField::EMAIL,
        OrganizationField::PHONE,
        OrganizationField::WEBSITE,
        OrganizationField::LOGO
    ];

    public function manager()
    {
        return $this->belongsTo(AccountManagerModel::class, OrganizationField::ACCOUNT_MANAGER_ID);
    }

    public function persons()
    {
        return $this->hasMany(PersonModel::class, PersonField::ORGANIZATION_ID);
    }


}
