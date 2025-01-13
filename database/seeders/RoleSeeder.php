<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = [
            'admin' => [
                'manage users',
                'manage roles',
                'manage tasks',
                'delete any task',
                'view all tasks',
                'manage categories'
            ],
            'manager' => [
                'manage tasks',
                'view all tasks',
                'manage categories'
            ],
            'user' => [
                'create tasks',
                'view assigned tasks',
                'update assigned tasks'
            ]
        ];

        foreach ($roles as $role => $permissions) {
            $roleInstance = Role::create(['name' => $role]);
            
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
                $roleInstance->givePermissionTo($permission);
            }
        }
    }
}