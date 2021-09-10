<?php

namespace Database\Seeders;

use App\Constant\RoleType;
use App\Models\AccountManagerModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password'  => Hash::make('admin'),
            'user_type' => RoleType::ADMIN
        ]);

        $idUser = User::create([
            'name'      => 'Manager',
            'email'     => 'manager@manager.com',
            'password'  => Hash::make('manager'),
            'user_type' => RoleType::MANAGER
        ]);

        AccountManagerModel::create([
            'full_name' => 'Manager',
            'user_id'   => $idUser->getKey()
        ]);
    }

}
