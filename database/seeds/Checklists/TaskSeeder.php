<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\TaskSubCategory;
use  App\Models\TaskCategory;
use  App\Models\CheckList;
use  App\Models\Task;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class TaskSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('tasks')->truncate();


        //Seed pour les boutiques
        $results = Excel::selectSheetsByIndex(0)->load('storage/tasks.xls', function($reader) {})->get();
        $rows = $results->toArray();

        $i = 0;
        foreach ($rows as $row) {
            if($row['task'] == null)
                break;
            $i = $i+1;
            $task = new Task();
            $task->description = $row['task'];
            $task->code =  sprintf("TB%02d", $i);
            $task->task_sub_category_id = TaskSubCategory::where('id', '<', 8)->where('name', $row['subcat'])->first()->id;
            $task->check_list_id = 1;
            $task->save();
        }

        //seed franchise
        $results = Excel::selectSheetsByIndex(1)->load('storage/tasks.xls', function($reader) {})->get();
        $rows = $results->toArray();

        $i = 0;
        foreach ($rows as $row) {
            if($row['task'] == null)
                break;
            $i = $i+1;
            $task = new Task();
            $task->description = $row['task'];
            $task->code =  sprintf("TF%02d", $i);
            $task->task_sub_category_id = TaskSubCategory::where('id', '<', 19)->where('name', $row['subcat'])
                ->orderBy('created_at', 'desc')->first()->id;
            $task->check_list_id = 2;
            $task->save();
        }

        //seed pdv classique
        $results = Excel::selectSheetsByIndex(3)->load('storage/tasks.xls', function($reader) {})->get();
        $rows = $results->toArray();

        $i = 0;
        foreach ($rows as $row) {
            if($row['task'] == null)
                break;
            $i = $i+1;
            $task = new Task();
            $task->description = $row['task'];
            $task->code =  sprintf("TPC%02d", $i);
            $task->task_sub_category_id = TaskSubCategory::where('id', '>', 13)->where('name', $row['subcat'])
                ->first()->id;
            $task->check_list_id = 3;
            $task->save();
        }

        //seed pdv lab
        $results = Excel::selectSheetsByIndex(2)->load('storage/tasks.xls', function($reader) {})->get();
        $rows = $results->toArray();

        $i = 0;
        foreach ($rows as $row) {
            if($row['task'] == null)
                break;
            $i = $i+1;
            $task = new Task();
            $task->description = $row['task'];
            $task->code =  sprintf("TPL%02d", $i);
            $task->task_sub_category_id = TaskSubCategory::where('id', '>', 13)->where('name', $row['subcat'])
                ->first()->id;
            $task->check_list_id = 4;
            $task->save();
        }

        //seed smart store
        $results = Excel::selectSheetsByIndex(4)->load('storage/tasks.xls', function($reader) {})->get();
        $rows = $results->toArray();
        $i = 0;
        foreach ($rows as $row) {
            if($row['task'] == null)
                break;
            $i = $i+1;
            $task = new Task();
            $task->description = $row['task'];
            $task->code =  sprintf("TSS%02d", $i);
            $cat = TaskCategory::where('name', $row['cat'])->first()->id;
            $task->task_sub_category_id = TaskSubCategory::where('task_category_id', $cat)->where('name', $row['subcat'])
                ->first()->id;
            $task->check_list_id = 6;
            $task->save();
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}