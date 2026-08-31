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
        User::create([
            'surname' => 'Литвинов',
            'patronymic' => 'Илья' ,
            'name' => 'Васильевич',
            'email' => 'litvinov374@gmail.com',
            'password' => bcrypt('Qwe123456+'),
            'role' => UserRoleEnum::Teacher,
            'group_id' => null,
        ]);
    }
}
