<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => Str::uuid(),
                'role_id' => DB::table('roles')->where("name", "admin")->pluck('id')->first(),
                'name' => 'Super Admin',
                'email' => 'superadmin@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('superadmin'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'role_id' => DB::table('roles')->where("name", "user")->pluck('id')->first(),
                'name' => 'User Example',
                'email' => 'user@email.com',
                'email_verified_at' => now(),
                'password' => Hash::make('userexample'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
