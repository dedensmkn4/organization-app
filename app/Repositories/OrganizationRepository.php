<?php

namespace App\Repositories;

use App\Constant\Fields\Constant;
use App\Constant\Fields\OrganizationField;
use App\Models\OrganizationModel;
use Illuminate\Support\Str;

class OrganizationRepository
{

    public function getAll()
    {
        return OrganizationModel::get();
    }

    public function findById($id)
    {
        return OrganizationModel::find($id);
    }

    public function create($request)
    {
        try {
            $logo       = $request->logo;
            $logo_name  = Str::random(16).'.'.$logo->extension();
            $logo->storeAs(Constant::STORAGE_PATH_ORGANIZATION, $logo_name);

        } catch (\Exception $e) {
            throw $e;
        }

        $org = OrganizationModel::create([
            'name'              => strip_tags($request->name),
            'email'             => strip_tags($request->email),
            'website'           => strip_tags($request->website),
            'logo'              => $logo_name,
            'phone'             => strip_tags($request->phone)
        ]);

        return $org;
    }

    /**
     * @throws \Exception
     */
    public function update($id, $request)
    {
        $manager = auth()->user()->manager;

        if(!$manager){
            throw new \Exception('Unauthorized');
        }

        $logo_name = null;
        $logo      = $request->logo;
        if($logo) {
            $logo_name = Str::random(16) . '.' . $logo->extension();
            $logo->storeAs(Constant::STORAGE_PATH_ORGANIZATION, $logo_name);
        }

        $org = OrganizationModel::find($id);

        $org->name     = strip_tags($request->name);
        $org->email    = strip_tags($request->email);
        $org->website  = strip_tags($request->website);
        $org->logo     = $logo_name ?? $org->logo;
        $org->phone    = strip_tags($request->phone);
        $org->save();

        return $org;
    }

    public function addManager($id, $manager_id)
    {
        $org = OrganizationModel::find($id);
        $org->account_manager_id = $manager_id;
        $org->save();

        return $org;
    }

    public function delete($id): bool
    {

        if(!auth()->user()->manager) return false;

        return OrganizationModel::where(['id' => $id,
            OrganizationField::ACCOUNT_MANAGER_ID => auth()->user()->manager->id])->delete();
    }
}
