<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRoleSeeder
 */
class UserRoleSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::table(config('access.assigned_roles_table'))->truncate();
        } elseif (env('DB_CONNECTION') == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.assigned_roles_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.assigned_roles_table') . ' CASCADE');
        }

        //Attach admin role to admin user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::first()->attachRole(1);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(2)->attachRole(2);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(3)->attachRole(3);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(4)->attachRole(4);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(5)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(6)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(7)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(8)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(9)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(10)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(11)->attachRole(5);

        /*//Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(12)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(13)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(14)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(15)->attachRole(5);

        //Attach user role to general user
        $user_model = config('auth.providers.users.model');
        $user_model = new $user_model;
        $user_model::find(16)->attachRole(5);*/


        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}