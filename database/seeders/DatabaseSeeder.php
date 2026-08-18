<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    public function run(): void
    {
        Group::create(['name' => 'ПИ-22']);
        Group::create(['name' => 'ИВТ-23']);

        User::create([
            'surname' => 'Админов',
            'patronymic' => 'Админович' ,
            'name' => 'Админ',
            'email' => 'admin@weblab.local',
            'password' => bcrypt('password'),
            'role' => UserRoleEnum::Teacher,
            'group_id' => null,
        ]);
    }
}
