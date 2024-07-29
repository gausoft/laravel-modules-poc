<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;

class CreatePermissionListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'core' => [
                'create_settings' => 'Create settings',
                'edit_settings' => 'Edit settings',
                'delete_settings' => 'Delete settings',
                'view_settings' => 'View settings',
                'create_users' => 'Create users',
                'edit_users' => 'Edit users',
                'delete_users' => 'Delete users',
                'view_users' => 'View users',
                'create_roles' => 'Create roles',
                'edit_roles' => 'Edit roles',
                'delete_roles' => 'Delete roles',
                'view_roles' => 'View roles',
            ],
            'stock' => [
                'creat_articles' => 'Create articles',
                'edit_articles' => 'Edit articles',
                'delete_articles' => 'Delete articles',
                'view_articles' => 'View articles',
                'create_categories' => 'Create categories',
                'edit_categories' => 'Edit categories',
                'delete_categories' => 'Delete categories',
                'view_categories' => 'View categories',
                'create_variants' => 'Create variants',
                'edit_variants' => 'Edit variants',
                'delete_variants' => 'Delete variants',
                'view_variants' => 'View variants',
                'create_stocks' => 'Create stocks',
                'edit_stocks' => 'Edit stocks',
                'delete_stocks' => 'Delete stocks',
                'view_stocks' => 'View stocks',
                'create_suppliers' => 'Create suppliers',
                'edit_suppliers' => 'Edit suppliers',
                'delete_suppliers' => 'Delete suppliers',
                'view_suppliers' => 'View suppliers',
                'create_purchases' => 'Create purchases',
                'edit_purchases' => 'Edit purchases',
                'delete_purchases' => 'Delete purchases',
                'view_purchases' => 'View purchases',
            ],
            'accounting' => [
                'create_sales' => 'Create sales',
                'edit_sales' => 'Edit sales',
                'delete_sales' => 'Delete sales',
                'view_sales' => 'View sales',
                'create_orders' => 'Create orders',
                'edit_orders' => 'Edit orders',
                'delete_orders' => 'Delete orders',
                'view_orders' => 'View orders',
                'create_invoices' => 'Create invoices',
                'edit_invoices' => 'Edit invoices',
                'delete_invoices' => 'Delete invoices',
                'view_invoices' => 'View invoices',
            ]
        ];

        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $permission) {
                \Spatie\Permission\Models\Permission::firstOrCreate([
                    'name' => $permission,
                    'module' => $module,
                ]);
            }
        }
    }
}
