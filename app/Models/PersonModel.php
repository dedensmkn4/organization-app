<?php

namespace App\Models;

use App\Constant\Fields\PersonField;
use App\Constant\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonModel extends Model
{
    use SoftDeletes;

    protected $table    = TableName::TABLE_PERSON;
    protected $fillable = [PersonField::ORGANIZATION_ID,
        PersonField::NAME,
        PersonField::EMAIL,
        PersonField::PHONE,
        PersonField::AVATAR];

    public function organization()
    {
        return $this->belongsTo(OrganizationModel::class, PersonField::ORGANIZATION_ID);
    }
}
