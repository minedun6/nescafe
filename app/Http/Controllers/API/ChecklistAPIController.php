<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\NetworkType;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskCategory;
use App\Models\TaskSubCategory;
use App\Models\CheckList;
use Illuminate\Support\Facades\Log;
use App\Services\Access\Facades\Access;
use App\Models\PhotoCategory;

use App\Http\Requests;

class ChecklistAPIController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function getTaskCats()
    {
        Log::info('[API] Update demanded from : '. Access::user()->name);
        $taskCats = TaskCategory::all();
        return $taskCats;
    }

    public function getTaskSubCats()
    {
        $taskSubCats = TaskSubCategory::all();
        return $taskSubCats;
    }

    public function getTasks()
    {
        $tasks = Task::all();
        return $tasks;
    }

    public function getChecklists()
    {
        $checklists = CheckList::all();
        return $checklists;
    }

    public function getPhotoCats()
    {
        $photoCats = PhotoCategory::all();
        return $photoCats;
    }
}
