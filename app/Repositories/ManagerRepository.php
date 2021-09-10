<?php

namespace App\Repositories;

use App\Constant\Fields\AccountManagerField;
use App\Constant\Fields\UserField;
use App\Constant\RoleType;
use App\Models\AccountManagerModel;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerRepository
{
    public function getAll()
    {
        return AccountManagerModel::get();
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                UserField::NAME      => strip_tags($request->name),
                UserField::EMAIL     => strip_tags($request->email),
                UserField::PASSWORD  => Hash::make($request->password,[]),
                UserField::USER_TYPE => RoleType::MANAGER
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        try {

            $manager = AccountManagerModel::create([
                AccountManagerField::ACCOUNT_MANAGER_USER_ID   => $user->id,
                AccountManagerField::FULL_NAME  => strip_tags($request->name)
            ]);

        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return $manager;
    }

    public function findById($id)
    {
        return AccountManagerModel::find($id);
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $manager = AccountManagerModel::find($id);
            $manager->full_name          = strip_tags($request->name);
            $manager->user->email       = strip_tags($request->email);
            $manager->user->password    = ($request->password) ? Hash::make($request->password) : $manager->user->password;
            $manager->push();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return $manager;
    }

    public function delete($id): bool
    {
        DB::beginTransaction();
        try {
            $manager = AccountManagerModel::find($id);
            User::where(['id' => $manager->user->id])->delete();
        }catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        try {
            AccountManagerModel::where(['id' => $id])->delete();
        }catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();
        return true;
    }
}
