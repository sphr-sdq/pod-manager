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
            'create-post' => 'Create Post',
            'update-post' => 'Update Post',
            'delete-post' => 'Delete Post',
            'restore-post' => 'Restore Post',
            'delete-post-force' => 'Delete Post Permanently',

            'create-pod' => 'Create Pod',
            'update-pod' => 'Update Pod',
            'delete-pod' => 'Delete Pod',
            'restore-pod' => 'Restore Pod',
            'delete-pod-force' => 'Delete Pod Permanently',

            'create-tag' => 'Create Tag',
            'update-tag' => 'Update Tag',
            'delete-tag' => 'Delete Tag',
            'restore-tag' => 'Restore Tag',
            'delete-tag-force' => 'Delete Tag Permanently',
        ];

        foreach ($permissions as $slug => $name) {

            \App\Models\Permission::create(['name' => $name, 'slug' => $slug]);
        }
    }
}
