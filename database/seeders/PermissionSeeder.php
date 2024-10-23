<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-posts' => 'Create Posts',
            'update-posts' => 'Update Posts',
            'delete-posts' => 'Delete Posts',
            'restore-posts' => 'Restore Posts',
            'delete-posts-force' => 'Delete Posts Permanently',
        ];

        foreach ($permissions as $slug => $name) {

            \App\Models\Permission::create(['name' => $name, 'slug' => $slug]);
        }
    }
}
