<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnums;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [RoleEnums::Applicant->value, RoleEnums::Employer->value];

        Role::create([
            'name' => $role[0],
            'guard_name' => 'api'
        ]);

        Role::create([
            'name' => $role[1],
            'guard_name' => 'api'
        ]);

        foreach (User::all() as $user) {
            $user->assignRole($role[rand(0, 1)]);
        }
    }
}
