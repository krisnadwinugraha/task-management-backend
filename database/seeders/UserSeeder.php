<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        $admin->assignRole('admin');

        // Create manager user
        $manager = User::factory()->create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password')
        ]);
        $manager->assignRole('manager');

        // Create regular users
        User::factory(2)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
