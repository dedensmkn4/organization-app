<?php

namespace App\Models;

use App\Constant\Fields\AccountManagerField;
use App\Constant\Fields\OrganizationField;
use App\Constant\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountManagerModel extends Model
{
    use SoftDeletes;

    protected $table    = TableName::TABLE_ACCOUNT_MANAGER;
    protected $fillable = [AccountManagerField::ACCOUNT_MANAGER_USER_ID,
        AccountManagerField::FULL_NAME];

    public function organizations()
    {
        return $this->hasMany(OrganizationModel::class, OrganizationField::ACCOUNT_MANAGER_ID);
    }

    public function user()
    {
        return $this->belongsTo(User::class, AccountManagerField::ACCOUNT_MANAGER_USER_ID);
    }
}
