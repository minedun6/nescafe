<?php

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class RoleTableSeeder
 */
class RoleTableSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.roles_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.roles_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.roles_table') . ' CASCADE');
        }

        //Create admin role, id of 1
        $role_model        = config('access.role');
        $admin             = new $role_model;
        $admin->name       = 'Super Administrator';
        $admin->all        = true;
        $admin->sort       = 1;
        $admin->created_at = Carbon::now();
        $admin->updated_at = Carbon::now();
        $admin->save();

        //id = 2
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Administrator';
        $user->sort       = 2;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //id = 3
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Superviseur';
        $user->sort       = 3;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //id = 4
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Visiteur';
        $user->sort       = 4;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        //id = 5
        $role_model       = config('access.role');
        $user             = new $role_model;
        $user->name       = 'Merch';
        $user->sort       = 5;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->save();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}