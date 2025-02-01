<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update guard_name to 'sanctum' for all permissions
        Permission::query()->update(['guard_name' => 'sanctum']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->update(['guard_name' => 'web']);
        // Optionally, you can add code to revert the guard_name changes if needed
    }
};
