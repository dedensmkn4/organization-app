<?php

namespace App\Repositories;

use App\Constant\Fields\Constant;
use App\Constant\Fields\PersonField;
use App\Models\OrganizationModel;
use App\Models\PersonModel;
use Illuminate\Support\Str;

class PersonRepository
{
    public function getByOrganization($org_id)
    {
        return PersonModel::where(PersonField::ORGANIZATION_ID, $org_id)->get();
    }

    public function findById($org_id, $id)
    {
        return PersonModel::where(PersonField::ORGANIZATION_ID, $org_id)->find($id);
    }

    /**
     * @throws \Exception
     */
    public function create($org_id, $request)
    {
        $org = OrganizationModel::find($org_id);
        if(auth()->user()->manager->id != $org->account_manager_id) {
            throw new \Exception('Unauthorized');
        }

        $avatar       = $request->avatar;
        $avatar_name  = Str::random(16).'.'.$avatar->extension();
        $avatar->storeAs(Constant::STORAGE_PATH_PERSON, $avatar_name);

        return PersonModel::create([
            PersonField::ORGANIZATION_ID => $org_id,
            PersonField::NAME            => strip_tags($request->name),
            PersonField::EMAIL           => strip_tags($request->email),
            PersonField::PHONE           => strip_tags($request->phone),
            PersonField::AVATAR          => $avatar_name
        ]);
    }

    public function update($org_id, $id, $request)
    {
        $org = OrganizationModel::find($org_id);
        if(!$org || !auth()->user()->manager || auth()->user()->manager->id != $org->account_manager_id) throw new \Exception('Unauthorized');

        $avatar_name = null;
        $avatar       = $request->avatar;
        if($avatar) :
            try {
                $avatar_name  = Str::random(16).'.'.$avatar->extension();
                $avatar->storeAs(Constant::STORAGE_PATH_PERSON, $avatar_name);

            } catch (\Exception $e) {
                throw $e;
            }
        endif;

        $pic = PersonModel::where(PersonField::ORGANIZATION_ID, $org_id)->find($id);

        $pic->name   = strip_tags($request->name);
        $pic->email  = strip_tags($request->email);
        $pic->phone  = strip_tags($request->phone);
        $pic->avatar = $avatar_name ?? $pic->avatar;
        $pic->save();

        return $pic;
    }

    public function delete($org_id, $id): bool
    {
        $org = OrganizationModel::find($org_id);
        if(!$org || !auth()->user()->manager || auth()->user()->manager->id != $org->account_manager_id) return false;

        return PersonModel::where([PersonField::ORGANIZATION_ID => $org_id, 'id' => $id])->delete();
    }
}
