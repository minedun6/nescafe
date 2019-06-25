<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\CheckList;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index()
    {
        return view('frontend.task.list');
    }

    public function show($id)
    {
        $task = Task::find($id);

        return view('frontend.task.detail', array(
            'task' => $task
        ));
    }

    public function create()
    {
        $check_lists = CheckList::all();
        return view('frontend.task.add', array(
            'check_lists' => $check_lists
        ));
    }

    public function store(Request $request)
    {
        $category_name = $request->category;
        $sub_category_name = $request->subcategory;
        if ($category_name == null || $category_name == '') {
            return redirect()->back()->withErrors(array(
                'category' => 'Nom de la Catégorie obligatoire !!'
            ));
        }

        if ($sub_category_name == null || $sub_category_name == '') {
            return redirect()->back()->withErrors(array(
                'sub_category' => 'Nom de la Sous Catégorie obligatoire !!'
            ));
        }

        DB::beginTransaction();

        $category = TaskCategory::where('name', 'like', '%' . $category_name . '%')
            ->first();
        if ($category == null) {
            $category = new TaskCategory();
            $category->name = $category_name;
            $category->save();
        }
        $sub_category = TaskSubCategory::where('name', 'like', '%' . $request->subcategory . '%')
            ->first();
        if ($sub_category == null) {
            $sub_category = new TaskSubCategory();
            $sub_category->task_category_id = $category->id;
            $sub_category->name = $sub_category_name;
            $sub_category->save();
        }

        $task = new Task();
        $task->task_sub_category_id = $sub_category->id;
        $task->description = $request->description ? nl2br($request->description) : '';
        $task->check_list_id = $request->check_list_id;
        $task->save();
        DB::commit();

        return redirect('/tasks/details/' . $task->id);
    }

    public function edit($id)
    {
        $check_lists = CheckList::all();
        $task = Task::find($id);

        return view('frontend.task.edit', array(
            'check_lists' => $check_lists,
            'task' => $task
        ));
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $category_name = $request->category;
        $sub_category_name = $request->subcategory;
        if ($category_name == null || $category_name == '') {
            return redirect()->back()->withErrors(array(
                'category' => 'Nom de la Catégorie obligatoire !!'
            ));
        }

        if ($sub_category_name == null || $sub_category_name == '') {
            return redirect()->back()->withErrors(array(
                'sub_category' => 'Nom de la Sous Catégorie obligatoire !!'
            ));
        }

        DB::beginTransaction();

        $category = TaskCategory::where('name', 'like', '%' . $category_name . '%')
            ->first();
        if ($category == null) {
            $category = new TaskCategory();
            $category->name = $category_name;
            $category->save();
        }
        $sub_category = TaskSubCategory::where('name', 'like', '%' . $request->subcategory . '%')
            ->first();
        if ($sub_category == null) {
            $sub_category = new TaskSubCategory();
            $sub_category->task_category_id = $category->id;
            $sub_category->name = $sub_category_name;
            $sub_category->save();
        }

        $task->task_sub_category_id = $sub_category->id;
        $task->description = $request->description ? nl2br($request->description) : '';
        $task->check_list_id = $request->check_list_id;
        $task->save();
        DB::commit();

        return redirect('/tasks/details/' . $task->id);
    }

    public function destory($id)
    {
        Task::destroy($id);

        return redirect('/tasks');
    }

    public function paginate(Request $request)
    {
        $tasks = Task::paginate($request->length);
        $tasks_count = $tasks->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $tasks_count,
            "recordsFiltered" => $tasks_count,
        ];
        $results["data"] = array();
        foreach ($tasks as $task) {
            $results["data"][] = array(
                $task->taskSubCategory ? $task->taskSubCategory->name : '',
                $task->taskSubCategory ? ($task->taskSubCategory->taskCategory ? $task->taskSubCategory->taskCategory->name : '') : '',
                $task->description ? $task->description : '',
                $task->checkList ? $task->checkList->name : '',
                '<center><a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/tasks/details/" . $task->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>
                    <a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/tasks/edit/" . $task->id) . '"><i
                                                        class="fa fa-edit"></i> edit</a></center>'

            );
        }

        return $results;
    }
}

