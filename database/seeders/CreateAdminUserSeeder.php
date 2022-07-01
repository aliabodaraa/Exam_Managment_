<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $user = User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'username' => 'admin',
        //     'password' => 'admin123',
        //     'dept_id' => 1,
        // ]);
        // $permissions=[
        //     'user_dit',
        //     'user_delete',
        //     'user_create',
        //     'users_list',
        //     'post_dit',
        //     'post_delete',
        //     'post_create',
        //     'posts_list',
        //     'courses_dit',
        //     'courses_delete',
        //     'courses_create',
        //     'courses_list',
        // ];
        // foreach ($permissions as $permission) {
        //     Permission::create([
        //         'name' => $permission
        //     ]);
        // }
        // $role = Role::create(['name' => 'admin']);

        // $permissions = Permission::pluck('id','id')->all();

        // $role->syncPermissions($permissions);

        // $user->assignRole([$role->id]);
    }
}
