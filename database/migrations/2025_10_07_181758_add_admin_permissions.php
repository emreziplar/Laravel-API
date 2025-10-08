<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $def_admin_permissions = [
            'role.create', 'role.update', 'role.delete',
            'permission.create', 'permission.update', 'permission.delete',
            'role_permission.create', 'role_permission_update', 'role_permission.delete'
        ];

        $insert_data = array_map(function ($permission) {
            return ['name' => $permission];
        }, $def_admin_permissions);

        DB::table('permissions')->insert($insert_data);

        $permissions = DB::table('permissions')->whereIn('name', $def_admin_permissions)->pluck('id')->toArray();
        $role_id = DB::table('roles')->where('role', 'super_admin')->value('id');

        $insert_data = array_map(function ($permission_id) use ($role_id) {
            return ['role_id' => $role_id, 'permission_id' => $permission_id];
        }, $permissions);

        DB::table('role_permissions')->insert($insert_data);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $def_admin_permissions = [
            'role.create', 'role.update', 'role.delete',
            'permission.create', 'permission.update', 'permission.delete',
            'role_permission.create', 'role_permission_update', 'role_permission.delete'
        ];
        $permission_ids = DB::table('permissions')->whereIn('name', $def_admin_permissions)->pluck('id')->toArray();

        if (!empty($permission_ids)) {
            $role_id = DB::table('roles')->where('role', 'super_admin')->value('id');

            DB::table('role_permissions')
                ->where('role_id', $role_id)
                ->whereIn('permission_id', $permission_ids)
                ->delete();
        }

        DB::table('permissions')
            ->whereIn('name', $def_admin_permissions)
            ->delete();

    }
};
