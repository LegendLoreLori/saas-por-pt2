<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create user related permissions
        Permission::create(['name' => 'user-browse']);
        Permission::create(['name' => 'user-show']);
        Permission::create(['name' => 'user-edit']);
        Permission::create(['name' => 'user-add']);
        Permission::create(['name' => 'user-delete']);
        Permission::create(['name' => 'user-trash-recover']);
        Permission::create(['name' => 'user-trash-remove']);
        Permission::create(['name' => 'user-trash-recover-all']);
        Permission::create(['name' => 'user-trash-empty']);

        // Create listing related permissions
        Permission::create(['name' => 'listing-browse']);
        Permission::create(['name' => 'listing-show']);
        Permission::create(['name' => 'listing-edit']);
        Permission::create(['name' => 'listing-add']);
        Permission::create(['name' => 'listing-delete']);
        Permission::create(['name' => 'listing-trash-recover']);
        Permission::create(['name' => 'listing-trash-remove']);
        Permission::create(['name' => 'listing-trash-recover-all']);
        Permission::create(['name' => 'listing-trash-empty']);

        // Create role management permission
        Permission::create(['name' => 'manage-listings']);
        Permission::create(['name' => 'manage-staff']);
        Permission::create(['name' => 'manage-clients']);

        // Create roles
        $client = Role::create(['name' => 'client']);
        $client->givePermissionTo([
            'user-edit',
            'user-delete',
            'listing-browse',
            'listing-show',
            'listing-edit',
            'listing-add',
            'listing-delete',
            'listing-trash-recover',
        ]);

        $staff = Role::create(['name' => 'staff']);
        $staff->syncPermissions($client->permissions()->get());
        $staff->givePermissionTo([
            'user-browse',
            'user-show',
            'user-add',
            'listing-trash-remove',
            'manage-clients',
            'manage-listings'
        ]);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Ensure Staff and Admin can't create listings
        $staff->revokePermissionTo('listing-add');
        $admin->revokePermissionTo('listing-add');
    }
}
