<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\TaskSubCategory;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class TaskSubCatSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('task_sub_gategories')->truncate();

        //ID = 1
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Extérieur et façade';
        $taskSubCat->task_category_id = 1;
        $taskSubCat->save();

        //ID = 2
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers Fun ,Tech et Travail';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 3
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers famille';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 4
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Communication boutique';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 5
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mobilier iPhone';
        $taskSubCat->task_category_id = 3;
        $taskSubCat->save();

        //ID = 6
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Libre service';
        $taskSubCat->task_category_id = 3;
        $taskSubCat->save();

        //ID = 7
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers tablettes';
        $taskSubCat->task_category_id = 3;
        $taskSubCat->save();

        //ID = 8
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Extérieur et façade';
        $taskSubCat->task_category_id = 4;
        $taskSubCat->save();

        //ID = 9
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers Fun';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 10
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers Tech';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 11
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers Travail';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 12
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers famille';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 13
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Communication';
        $taskSubCat->task_category_id = 2;
        $taskSubCat->save();

        //ID = 14
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Extérieur et façade';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 15
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Intérieur';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 16
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers mobile';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 17
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Univers Internet';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 18
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Communication';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 19
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Acceuil';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 20
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Vitrine';
        $taskSubCat->task_category_id = 15;
        $taskSubCat->save();

        //ID = 21
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Vitrine';
        $taskSubCat->task_category_id = 5;
        $taskSubCat->save();

        //ID = 22
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mur d\'écran';
        $taskSubCat->task_category_id = 6;
        $taskSubCat->save();

        //ID = 23
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Display';
        $taskSubCat->task_category_id = 6;
        $taskSubCat->save();

        //ID = 24
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Smart gate';
        $taskSubCat->task_category_id = 7;
        $taskSubCat->save();

        //ID = 25
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Etagère';
        $taskSubCat->task_category_id = 7;
        $taskSubCat->save();

        //ID = 26
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mural accessoires';
        $taskSubCat->task_category_id = 7;
        $taskSubCat->save();

        //ID = 27
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mobilier TV fun';
        $taskSubCat->task_category_id = 7;
        $taskSubCat->save();

        //ID = 28
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Smart gate';
        $taskSubCat->task_category_id = 8;
        $taskSubCat->save();

        //ID = 29
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Etagère';
        $taskSubCat->task_category_id = 8;
        $taskSubCat->save();

        //ID = 30
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mural accessoires';
        $taskSubCat->task_category_id = 8;
        $taskSubCat->save();

        //ID = 31
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'TV famille';
        $taskSubCat->task_category_id = 8;
        $taskSubCat->save();

        //ID = 32
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Smart gate';
        $taskSubCat->task_category_id = 9;
        $taskSubCat->save();

        //ID = 33
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Etagère';
        $taskSubCat->task_category_id = 9;
        $taskSubCat->save();

        //ID = 34
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Mural accessoires';
        $taskSubCat->task_category_id = 9;
        $taskSubCat->save();

        //ID = 35
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Smart gate';
        $taskSubCat->task_category_id = 10;
        $taskSubCat->save();

        //ID = 36
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'TV services';
        $taskSubCat->task_category_id = 10;
        $taskSubCat->save();

        //ID = 37
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Tables shop';
        $taskSubCat->task_category_id = 11;
        $taskSubCat->save();

        //ID = 38
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Hot spot';
        $taskSubCat->task_category_id = 12;
        $taskSubCat->save();

        //ID = 39
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Borne ici vous pouvez';
        $taskSubCat->task_category_id = 13;
        $taskSubCat->save();

        //ID = 40
        $taskSubCat = new TaskSubCategory();
        $taskSubCat->name = 'Affichage dynamique ';
        $taskSubCat->task_category_id = 14;
        $taskSubCat->save();




        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}