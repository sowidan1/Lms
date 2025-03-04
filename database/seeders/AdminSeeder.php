<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'osamaadmin@gmail.com'
        ], [
            'name'     => 'Osama Admin',
            'password' => Hash::make('StrongPassword!!112211'),
            'role'     => User::ROLE_ADMIN
        ]);
    }
}
