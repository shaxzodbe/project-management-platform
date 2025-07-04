<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::findOrCreate('create-project');
        Permission::findOrCreate('view-any-project');
        Permission::findOrCreate('view-project');
        Permission::findOrCreate('update-project');
        Permission::findOrCreate('delete-project');

        Permission::findOrCreate('create-task');
        Permission::findOrCreate('view-any-task');
        Permission::findOrCreate('view-task');
        Permission::findOrCreate('update-task');
        Permission::findOrCreate('delete-task');
        Permission::findOrCreate('assign-task');
        Permission::findOrCreate('update-task-status');

        Permission::findOrCreate('view-any-user');
        Permission::findOrCreate('view-user');
        Permission::findOrCreate('create-user');
        Permission::findOrCreate('update-user');
        Permission::findOrCreate('delete-user');
        Permission::findOrCreate('manage-users');

        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());

        $projectManagerRole = Role::findOrCreate('project_manager');
        $projectManagerRole->givePermissionTo([
            'create-project', 'view-any-project', 'view-project', 'update-project', 'delete-project',
            'create-task', 'view-any-task', 'view-task', 'update-task', 'delete-task',
            'assign-task', 'update-task-status',
            'view-user',
        ]);

        $developerRole = Role::findOrCreate('developer');
        $developerRole->givePermissionTo([
            'view-any-project', 'view-project',
            'view-any-task', 'view-task',
            'update-task-status',
            'view-user',
        ]);

        $userRole = Role::findOrCreate('user');
        $userRole->givePermissionTo([
            'create-project',
            'view-any-project', 'view-project',
            'view-any-task', 'view-task',
            'view-user',
        ]);


        $adminUser = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
        ]);
        $adminUser->assignRole('admin');

        $pmUser = User::firstOrCreate(['email' => 'pm@example.com'], [
            'name' => 'Project Manager',
            'password' => bcrypt('password'),
        ]);
        $pmUser->assignRole('project_manager');

        $devUser = User::firstOrCreate(['email' => 'dev@example.com'], [
            'name' => 'Developer',
            'password' => bcrypt('password'),
        ]);
        $devUser->assignRole('developer');

        $regularUser = User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Regular User',
            'password' => bcrypt('password'),
        ]);
        $regularUser->assignRole('user');
    }
}
