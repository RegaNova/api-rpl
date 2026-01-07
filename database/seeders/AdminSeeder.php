<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRoleEnum;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()
            ->admin()
            ->create();

        $admin->assignRole(UserRoleEnum::ADMIN->value);
    }
}
