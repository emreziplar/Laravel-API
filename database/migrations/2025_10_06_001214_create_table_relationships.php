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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                ->on('roles')
                ->references('id')
                ->nullOnDelete();
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->foreign('role_id')
                ->on('roles')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('permission_id')
                ->on('permissions')
                ->references('id')
                ->cascadeOnDelete();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')
                ->on('categories')
                ->references('id')
                ->cascadeOnDelete();
        });

        Schema::table('category_translations', function (Blueprint $table) {
            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->cascadeOnDelete();
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->nullOnDelete();
        });

        Schema::table('blog_translations', function (Blueprint $table) {
            $table->foreign('blog_id')
                ->on('blogs')
                ->references('id')
                ->cascadeOnDelete();
            $table->foreign('author_id')
                ->on('user')
                ->references('id')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('role_permissions', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['permission_id']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::table('category_translations', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('blogs', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('blog_translations', function (Blueprint $table) {
            $table->dropForeign(['blog_id']);
            $table->dropForeign(['author_id']);
        });

    }
};
