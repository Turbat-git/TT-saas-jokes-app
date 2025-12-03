<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Laravel\Prompts\Output\ConsoleOutput;
use Spatie\Permission\Models\Permission;
use Symfony\Component\Console\Helper\ProgressBar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start = now();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();



        $roleSuperUser = Role::create(['name' => 'super-user']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleStaff = Role::create(['name' => 'staff']);
        $roleClient = Role::create(['name' => 'client']);
        $guestClient = Role::create(['name' => 'guest']);

        // Define permissions (add all your app permissions here)
        $seedPermissions = [
            'user-browse','user-read','user-edit', 'user-edit-own','user-add','user-delete','user-delete-own', 'user-register', 'user-read-own',

            'role-browse','role-read','role-edit','role-add','role-delete',

            'permission-browse','permission-read',

            'category-browse','category-read','category-edit','category-add','category-delete',

            'joke-browse', 'joke-browse-random','joke-read','joke-edit','joke-edit-own','joke-add','joke-delete','joke-delete-own',

            'data-backup','data-restore',
        ];

        $output = new ConsoleOutput();
        $progress = new ProgressBar($output, count($seedPermissions));
        $output->writeln("");
        $output->writeln('Seed Permissions');
        $progress->start();

        foreach ($seedPermissions as $newPermission) {
            $newPermission = Str::of($newPermission)->kebab();

            $permission = Permission::firstOrCreate(['name' => $newPermission]);
            $progress->advance();
        }

        $progress->finish();
        $output->writeln('');

        $output->writeln('Create Roles with Permissions');
        $output->writeln('');

        /* Create Super-Admin Role and Sync Permissions */

        $progress = new ProgressBar($output, 4);
        $output->writeln("");
        $output->writeln('Grant Permissions to Roles');
        $progress->start();

        $roleSuperAdmin = Role::firstOrCreate(
            ['name' => 'super-user']
        );

        $roleSuperAdmin->syncPermissions(Permission::all());
        $progress->advance();

        /* Create Admin Role and Sync Permissions */

        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);

        $adminPermissions = [
            // Users
            'user-browse','user-read','user-edit','user-add','user-delete',

            // Roles
            'role-browse','role-read','role-edit','role-add','role-delete',

            // Permissions (read only)
            'permission-browse','permission-read',

            // Categories
            'category-browse','category-read','category-edit','category-add','category-delete',

            // Jokes
            'joke-browse','joke-read','joke-edit','joke-add','joke-delete',
        ];

        foreach ($adminPermissions as $key => $permission) {
            $adminPermissions[$key] = Str::of($permission)->kebab()->toString();
        }

        $roleAdmin->syncPermissions($adminPermissions);
        $progress->advance();

        /* Create Staff Role and Sync Permissions */

        $roleStaff = Role::firstOrCreate(['name' => 'staff']);

        $staffPermissions = [
            // Users — staff can manage clients + themselves
            'user-browse','user-read','user-add','user-edit','user-delete',
            'user-edit-own','user-read-own',

            // Roles (read only)
            'role-browse','role-read',

            // Permissions (read only)
            'permission-browse',

            // Categories
            'category-browse','category-read','category-edit','category-add','category-delete',

            // Jokes
            'joke-browse','joke-read','joke-edit','joke-add','joke-delete','joke-delete-own',
        ];

        foreach ($staffPermissions as $key => $permission) {
            $staffPermissions[$key] = Str::of($permission)->kebab()->toString();
        }

        $roleStaff->syncPermissions($staffPermissions);
        $progress->advance();

        /* Create Client Role and Sync Permissions */

        $roleClient = Role::firstOrCreate(['name' => 'client']);

        $clientPermissions = [
            // Users — client can only read/edit own profile
            'user-edit-own','user-read-own', 'user-delete-own',

            // Categories (browse & read only)
            'category-browse','category-read',

            // Jokes
            'joke browse','joke read','joke add','joke edit-own','joke delete-own',
        ];

        foreach ($clientPermissions as $key => $permission) {
            $clientPermissions[$key] = Str::of($permission)->kebab()->toString();
        }

        $roleClient->syncPermissions($clientPermissions);
        $progress->advance();

        /* Permission-less Roles */

        $output->writeln("Adding roles, without permissions");

        $guestClient = Role::firstOrCreate(['name' => 'guest']);

        $guestPermissions = [
            'user-register'
        ];

        foreach ($guestPermissions as $key => $permission) {
            $guestPermissions[$key] = Str::of($permission)->kebab()->toString();
        }

        $guestClient->syncPermissions($guestPermissions);
        $progress->advance();

        $progress->finish();
        $output->writeln(" ");

        $time = $start->diffInSeconds(now());
        $output->writeln("Roles & Permissions completed: $time seconds");
        $output->writeln(" ");
    }
}
