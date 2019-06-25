<?php

namespace App\Http\Controllers\API\v2;

use App\Models\Access\User\User;
use App\Models\FicheTechnique;
use App\Models\Guideline;
use App\Models\MessageSeen;
use App\Models\UserLogs;
use App\Models\Visit;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use App\Models\Message;
use App\Models\Photo;
use App\Models\Access\Role\Role;

class DocumentAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getGuidelines()
    {
        $guidelines = Guideline::all();
        return $guidelines;
    }

    public function getFichesTechniques()
    {
        $fiches = FicheTechnique::all();
        return $fiches;
    }

    public function addGuidelineSeen(Request $request){
        $data = $request->json()->all();
        $user = Access::user();

        DB::beginTransaction();
        $guideline = Guideline::find($data['doc_id']);

        $userLog = UserLogs::where('user_id', $user->id)
            ->where('target', 'guideline')
            ->where('target_id', $guideline->id)->first();
        if (!$userLog){
            $userLog = new UserLogs();
            $userLog->user_id = $user->id;
            $userLog->target = 'guideline';
            $userLog->target_id = $guideline->id;
            $userLog->save();
        }

        DB::commit();
        return response()->json(['response' => 'ok']);
    }

    public function addFicheTechniqueSeen(Request $request){
        $data = $request->json()->all();
        $user = Access::user();

        DB::beginTransaction();
        $fiche = Guideline::find($data['doc_id']);

        $userLog = UserLogs::where('user_id', $user->id)
            ->where('target', 'fiche')
            ->where('target_id', $fiche->id)->first();
        if (!$userLog){
            $userLog = new UserLogs();
            $userLog->user_id = $user->id;
            $userLog->target = 'fiche';
            $userLog->target_id = $fiche->id;
            $userLog->save();
        }

        DB::commit();
        return response()->json(['response' => 'ok']);
    }

}
