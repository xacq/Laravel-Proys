<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone_number' => '12345678901', 'password' => bcrypt('password')],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone_number' => '12345678902', 'password' => bcrypt('password')],
            ['name' => 'Alice Brown', 'email' => 'alice@example.com', 'phone_number' => '12345678903', 'password' => bcrypt('password')],
            ['name' => 'Bob Green', 'email' => 'bob@example.com', 'phone_number' => '12345678904', 'password' => bcrypt('password')],
            ['name' => 'Charlie White', 'email' => 'charlie@example.com', 'phone_number' => '12345678905', 'password' => bcrypt('password')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

