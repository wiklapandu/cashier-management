<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = [
            [
                "name"      => "Admin",
                "email"     => 'admin@admin.com',
                "password"  => 'kuk!r4kur4kur4',
                "roles"     => [
                    [
                        'name'          => 'admin',
                        'guard_name'    => 'web',
                    ],
                ],
            ],
            [
                "name"      => "Kasir",
                "email"     => 'kasir@admin.com',
                "password"  => 'kuk!r4kur4kur4',
                "roles"     => [
                    [
                        'name'          => 'kasir',
                        'guard_name'    => 'web',
                    ],
                ],
            ],
        ];

        DB::beginTransaction();
        try {
            foreach ($admin as $userData) {
                $user = new User;
                $user->name     = $userData['name'];
                $user->email    = $userData['email'];
                $user->password = Hash::make($userData['password']);
                $user->save();

                $roles      = $userData['roles'];
                $rolesMap   = is_array($roles) ? array_map(fn ($role) => Role::where($role)->first(), $roles) : [];
                $user->syncRoles($rolesMap);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
