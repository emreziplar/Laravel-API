<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $super_admin_role = DB::table('roles')->where('role', 'super_admin')->first();
        if (!$super_admin_role) {
            $super_admin_role_id = DB::table('roles')->insertGetId([
                'role' => 'super_admin',
                'created_at' => now()
            ]);
        } else {
            $super_admin_role_id = $super_admin_role->id;
        }


        $super_admin_user = DB::table('users')->where('email', 'superadmin@example.com')->first();
        if (!$super_admin_user)
            DB::table('users')->insert([
                'role_id' => $super_admin_role_id,
                'name' => 'John Doe',
                'email' => 'superadmin@example.com',
                'status' => 1,
                'password' => Hash::make('123'),
                'created_at' => now()
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->where('role', 'super_admin')->delete();
        DB::table('users')->where('email', 'superadmin@example.com')->delete();
    }
};
