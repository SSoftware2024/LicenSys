<?php

namespace Database\Seeders;

use App\Enum\TypeUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Tiago Alves',
            'email' => 'teste@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('teste123'),
            'type' => TypeUser::ADMIN->value,
            'activated' => true
        ]);
    }
}
