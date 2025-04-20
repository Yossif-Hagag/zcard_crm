<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //seals perms
        $sealsPermissions = [];
        $sealsPermissions[] = Permission::create(['name' => 'list addresses']);
        $sealsPermissions[] = Permission::create(['name' => 'view addresses']);
        $sealsPermissions[] = Permission::create(['name' => 'create addresses']);
        $sealsPermissions[] = Permission::create(['name' => 'update addresses']);
        $sealsPermissions[] = Permission::create(['name' => 'delete addresses']);

        $sealsPermissions[] = Permission::create(['name' => 'list comments']);
        $sealsPermissions[] = Permission::create(['name' => 'view comments']);
        $sealsPermissions[] = Permission::create(['name' => 'create comments']);
        $sealsPermissions[] = Permission::create(['name' => 'update comments']);
        $sealsPermissions[] = Permission::create(['name' => 'delete comments']);

        $sealsPermissions[] = Permission::create(['name' => 'list leads']);
        $sealsPermissions[] = Permission::create(['name' => 'view leads']);
        $sealsPermissions[] = Permission::create(['name' => 'create leads']);
        $sealsPermissions[] = Permission::create(['name' => 'delete leads']);
        $sealsPermissions[] = Permission::create(['name' => 'update leads']);
        $sealsPermissions[] = Permission::create(['name' => 'list todo']);


        //confirmation deal perms
        $confirmation_dealPermissions = [];
        $confirmation_dealPermissions[] = Permission::create(['name' => 'list deals']);
        $confirmation_dealPermissions[] = Permission::create(['name' => 'view deals']);
        $confirmation_dealPermissions[] = Permission::create(['name' => 'create deals']);
        $confirmation_dealPermissions[] = Permission::create(['name' => 'update deals']);
        $confirmation_dealPermissions[] = Permission::create(['name' => 'delete deals']);


        //printing perms
        $printingsPermissions = [];
        $printingsPermissions[] = Permission::create(['name' => 'list printings']);

        //shipping && delivery boy  perms
        $shippingPermissions = [];
        $shippingPermissions[] = Permission::create(['name' => 'list shipping']);
        $shippingPermissions[] = Permission::create(['name' => 'update shipping status']);

        //crm perms
        $crmPermissions = [];
        $crmPermissions[] = Permission::create(['name' => 'crm']);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'list contracts']);
        Permission::create(['name' => 'view contracts']);
        Permission::create(['name' => 'create contracts']);
        Permission::create(['name' => 'update contracts']);
        Permission::create(['name' => 'delete contracts']);

        Permission::create(['name' => 'list cards']);
        Permission::create(['name' => 'view cards']);
        Permission::create(['name' => 'create cards']);
        Permission::create(['name' => 'update cards']);
        Permission::create(['name' => 'delete cards']);

        Permission::create(['name' => 'list stages']);
        Permission::create(['name' => 'view stages']);
        Permission::create(['name' => 'create stages']);
        Permission::create(['name' => 'update stages']);
        Permission::create(['name' => 'delete stages']);

        Permission::create(['name' => 'list statuses']);
        Permission::create(['name' => 'view statuses']);
        Permission::create(['name' => 'create statuses']);
        Permission::create(['name' => 'update statuses']);
        Permission::create(['name' => 'delete statuses']);

        Permission::create(['name' => 'dashboard']); // dashboard

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'Super Admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail('admin@admin.com')->first();
        if ($user) {
            $user->assignRole($adminRole);
        }
        //Director
        $DirectorRole = Role::create(['name' => 'Director', 'parent_id' => $adminRole->id]);
        $DirectorRole->givePermissionTo($sealsPermissions);
        $dirctor = \App\Models\User::whereEmail('dirctor1@dirctor.com')->first();
        if ($dirctor) {
            $dirctor->assignRole($DirectorRole);
        }
        //TeamLeader
        $TeamLeaderRole = Role::create(['name' => 'Team Leader', 'parent_id' => $DirectorRole->id]);
        $TeamLeaderRole->givePermissionTo($sealsPermissions);
        $TeamLeaderRole->givePermissionTo($shippingPermissions);
        for ($i = 1; $i <= 5; $i++) {
            $teamleader = \App\Models\User::whereEmail('teamleader' . $i . '@teamleader.com')->first();
            if ($teamleader) {
                $teamleader->assignRole($TeamLeaderRole);
            }
        }
        //sales
        $sealsRole = Role::create(['name' => 'Sales', 'parent_id' => $TeamLeaderRole->id]);
        $sealsRole->givePermissionTo($sealsPermissions);
        //confirmation deal
        $confirmation_dealRole = Role::create(['name' => 'Confirmation Deal', 'parent_id' => $adminRole->id]);
        $confirmation_dealRole->givePermissionTo($confirmation_dealPermissions);
        //printing
        $printingRole = Role::create(['name' => 'Printing', 'parent_id' => $adminRole->id]);
        $printingRole->givePermissionTo($printingsPermissions);
        //Shipping Operation
        $shippingRole = Role::create(['name' => 'Shipping Operation', 'parent_id' => $adminRole->id]);
        $shippingRole->givePermissionTo($shippingPermissions);
        //Delivery Boy
        $deliveryboyRole = Role::create(['name' => 'Delivery Boy', 'parent_id' => $adminRole->id]);
        $deliveryboyRole->givePermissionTo($shippingPermissions);
        //Shipping Company
        $shippingCompanyRole = Role::create(['name' => 'Shipping Company', 'parent_id' => $adminRole->id]);
        $shippingCompanyRole->givePermissionTo($shippingPermissions);
        //Social Media Boy
        $SocialMediaBoyRole = Role::create(['name' => 'Social Media Boy', 'parent_id' => $adminRole->id]);
        $SocialMediaBoyRole->givePermissionTo($sealsPermissions);
        //Viewer Admin
        $viewerAdminRole = Role::create(['name' => 'Viewer Admin', 'parent_id' => $adminRole->id]);
        $viewerAdminRole->givePermissionTo($allPermissions);
        //crm
        $sealsRole->givePermissionTo($crmPermissions);
        $confirmation_dealRole->givePermissionTo($crmPermissions);
        $DirectorRole->givePermissionTo($crmPermissions);
        $TeamLeaderRole->givePermissionTo($crmPermissions);
        $SocialMediaBoyRole->givePermissionTo($crmPermissions);
    }
}
