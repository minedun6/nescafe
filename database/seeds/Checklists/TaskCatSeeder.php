<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\TaskCategory;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class TaskCatSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('task_gategories')->truncate();

        //ID = 1
        $taskCat = new TaskCategory();
        $taskCat->name = 'La boutique';
        $taskCat->save();

        //ID = 2
        $taskCat = new TaskCategory();
        $taskCat->name = 'Linéaire';
        $taskCat->save();

        //ID = 3
        $taskCat = new TaskCategory();
        $taskCat->name = 'LS';
        $taskCat->save();

        //ID = 4
        $taskCat = new TaskCategory();
        $taskCat->name = 'La franchise';
        $taskCat->save();

        //ID = 5
        $taskCat = new TaskCategory();
        $taskCat->name = 'Extérieur';
        $taskCat->save();

        //ID = 6
        $taskCat = new TaskCategory();
        $taskCat->name = 'Espace partenaire';
        $taskCat->save();

        //ID = 7
        $taskCat = new TaskCategory();
        $taskCat->name = 'Univers fun';
        $taskCat->save();

        //ID = 8
        $taskCat = new TaskCategory();
        $taskCat->name = 'Univers famille';
        $taskCat->save();

        //ID = 9
        $taskCat = new TaskCategory();
        $taskCat->name = 'Univers travail';
        $taskCat->save();

        //ID = 10
        $taskCat = new TaskCategory();
        $taskCat->name = 'Univers services';
        $taskCat->save();

        //ID = 11
        $taskCat = new TaskCategory();
        $taskCat->name = 'Shop';
        $taskCat->save();

        //ID = 12
        $taskCat = new TaskCategory();
        $taskCat->name = 'Hot spot';
        $taskCat->save();

        //ID = 13
        $taskCat = new TaskCategory();
        $taskCat->name = 'Borne ici vous pouvez';
        $taskCat->save();

        //ID = 14
        $taskCat = new TaskCategory();
        $taskCat->name = 'Affichage dynamique';
        $taskCat->save();

        //ID = 15
        $taskCat = new TaskCategory();
        $taskCat->name = '-';
        $taskCat->save();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}