<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $roleNames  = [
            [
                "name"          => "admin",
                "guard_name"    => "web",
                "permissions"   => [
                    /* Order Permission */ 
                    [
                        "name"          => "create order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "edit order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "read order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "delete order",
                        "guard_name"    => "web"
                    ],

                    /* Product Permission */ 
                    [
                        "name"          => "create product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "edit product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "read product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "delete product",
                        "guard_name"    => "web"
                    ],

                    /* User Permission */ 
                    [
                        "name"          => "create user",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "edit user",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "read user",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "delete user",
                        "guard_name"    => "web"
                    ],

                ]
            ],
            [
                "name"          => "kasir",
                "guard_name"    => "web",
                "permissions"   => [
                    /* Order Permission */ 
                    [
                        "name"          => "create order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "edit order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "read order",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "delete order",
                        "guard_name"    => "web"
                    ],

                    /* Product Permission */ 
                    [
                        "name"          => "create product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "edit product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "read product",
                        "guard_name"    => "web"
                    ],
                    [
                        "name"          => "delete product",
                        "guard_name"    => "web"
                    ],
                ]
            ],
        ];

        foreach ($roleNames as $roles) {
            $role = Role::create([
                'guard_name'    => $roles['guard_name'],
                'name'          => $roles['name'],
            ]);

            if (is_array($roles['permissions'])) {
                $rolePermissions = [];
                foreach ($roles['permissions'] as $permission) {
                    $permissionModel    = Permission::where($permission);
                    Log::info(($permissionModel->exists() ? $permissionModel->first() : 'false'));

                    if ($permissionModel->exists()) {
                        Log::info('exists');
                        $rolePermissions[]  = $permissionModel->first()->name;
                    } else {
                        $permission  = new Permission($permission);
                        $permission->save();
                        Log::info(json_encode($permission, JSON_PRETTY_PRINT));
                        $rolePermissions[] = $permission->name;
                    }
                }

                $role->syncPermissions($rolePermissions);
            }
        }
    }
}
