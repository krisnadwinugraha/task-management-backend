<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update guard_name to 'sanctum' for all permissions
        Permission::query()->update(['guard_name' => 'sanctum']);

        // Update guard_name to 'sanctum' for all roles
        Role::query()->update(['guard_name' => 'sanctum']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert guard_name to 'web' for all permissions
        Permission::query()->update(['guard_name' => 'web']);

        // Revert guard_name to 'web' for all roles
        Role::query()->update(['guard_name' => 'web']);
    }
};
