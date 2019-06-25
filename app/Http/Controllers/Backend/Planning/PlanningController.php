<?php

namespace App\Http\Controllers\Backend\Planning;

use App\Http\Controllers\Controller;
use App\Jobs\GeneratePlanning;
use App\Models\Visit;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use App\Models\Access\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Request;
use App\Models\Access\Role\Role;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PlanningController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function requestPlanningGeneration()
    {
        return view('frontend.planning.add');
    }

    public function detailPlanning($id){
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return redirect('/');
        }

        if (Visit::where('user_id',$id)->first()) {
            $last_visit = Visit::where('user_id',$merch->id)->orderBy('visit_date', 'DESC')->first()->visit_date->format('d/m/Y');
            $last_update = Visit::where('user_id',$merch->id)->orderBy('created_at', 'DESC')->first()->created_at->format('d/m/Y');
        }
        else {
            $last_visit = "N/A";
            $last_update = "N/A";
        }

        return view('frontend.planning.detail', array(
            'merch' => $merch,
            'last_visit' => $last_visit,
            'last_update' => $last_update
        ));
    }

    public function paginateMerchandiser(Request $request) {
        $merchs_query = Role::where('name', 'Merch')->first()->users();
        $merchs = $merchs_query->get();
        $merchs_count = $merchs_query->count();

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $merchs_count,
            "recordsFiltered" => $merchs_count,
        ];
        $results["data"] = array();
        foreach ($merchs as $merch) {
            $name = $merch->name;
            $id = $merch->id;
            if (Visit::where('user_id',$id)->first()) {
                $last_visit = Visit::where('user_id', $id)->orderBy('visit_date', 'DESC')->first()->visit_date->format('d/m/Y');
                $last_update = Visit::where('user_id', $id)->orderBy('created_at', 'DESC')->first()->created_at->format('d/m/Y');
            }
            else {
                $last_visit = "N/A";
                $last_update = "N/A";
            }
            $results["data"][] = array(
                $name,
                $last_visit,
                $last_update,
                '<center><a class="btn btn-sm dark" id="btn-detail"
                                           href="' . route('planning.merchandiser', ['id' => $id]) . '"><i
                                                    class="fa fa-info"></i> Planning</a></center>'
            );

        }
        return $results;

    }

    public function preGeneratePlanning(Request $request, $id)
    {
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return response()->json(['response'=>'ko', 'message'=>'Le serveur n\'a pas pu identifier le merchandiser, Veuillez actualiser la page et réessayer']);
        }

        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false) {

            return response()->json(['response'=>'ko', 'message'=>'Date invalide']);
        }
        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        if ($date_debut > $date_fin){
            return response()->json(['response'=>'ko', 'message'=>'Date début > Date fin :o']);
        }

        $first_week = $request->week_nbr;

        $visits = Visit::where('user_id', $merch->id)
            ->where('visit_date', '>=', $date_debut)
            ->where('visit_date', '<=', $date_fin);

        $planifie = $visits->count();
        $visited = $visits->where('is_answered', true)->count();

        return response()->json(['response'=>'ok', 'visits'=> $planifie, 'visited'=> $visited]);
    }

    public function preGeneratePlanningForAll(Request $request)
    {
        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false) {

            return response()->json(['response'=>'ko', 'message'=>'Date invalide']);
        }
        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        if ($date_debut > $date_fin){
            return response()->json(['response'=>'ko', 'message'=>'Date début > Date fin :o']);
        }

        $first_week = $request->week_nbr;

        $visits = Visit::where('visit_date', '>=', $date_debut)
            ->where('visit_date', '<=', $date_fin);

        $planifie = $visits->count();
        $visited = $visits->where('is_answered', true)->count();

        return response()->json(['response'=>'ok', 'visits'=> $planifie, 'visited'=> $visited]);
    }
    public function generatePlanning(Request $request, $id)
    {
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return 'ko';
        }

        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false) {
            return 'ko';
        }
        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        $first_week = $request->week_nbr;

        $path = 'storage/' . $id . '.xlsx';
        $this->dispatch(new GeneratePlanning($id,$path,$date_debut,$date_fin,$first_week));

        return 'ok';
    }

    public function generatePlanningForAll(Request $request)
    {
        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false)
        {
            return 'ko';
        }
        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        $first_week = $request->week_nbr;

        $merchs = Role::where('name', 'Merch')->first()->users()->get();
        foreach ($merchs as $merch) {
            $user_id = $merch->id;
            $path = 'storage/' . $user_id . '.xlsx';
            if (file_exists (storage_path($user_id . '.xlsx')))
                $this->dispatch(new GeneratePlanning($user_id,$path,$date_debut,$date_fin,$first_week));
        }

        return 'ok';
    }

    public function downloadPlanning($id){
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return redirect('/');
        }
        $file= storage_path() . '/' . $merch->id . ".xlsx";
        return response()->download($file, $merch->name . '.xlsx');
    }

    public function deletePlanningForAll(Request $request)
    {
        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false)
        {
            return 'ko';
        }

        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        DB::beginTransaction();
        Visit::where('visit_date', '>=', $date_debut)
            ->where('visit_date', '<=', $date_fin)
            ->where('is_answered', false)
            ->where('is_answered_branding', false)
            ->where('is_answered_display', false)
            ->where('is_answered_online', false)
            ->where('is_answered_ilv', false)
            ->delete();
        DB::commit();

        return "ok";
    }

    public function deletePlanning(Request $request, $id)
    {
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return redirect('/');
        }

        if ($request->date_debut == "" || $request->date_fin == "" ||
            Carbon::createFromFormat("d/m/Y", $request->date_debut) == false ||
            Carbon::createFromFormat("d/m/Y", $request->date_fin) == false)
        {
            return 'ko';
        }

        $date_debut = Carbon::createFromFormat("d/m/Y", $request->date_debut);
        $date_debut->hour = 0;
        $date_debut->minute = 0;
        $date_debut->second = 0;
        $date_fin = Carbon::createFromFormat("d/m/Y", $request->date_fin);
        $date_fin->hour = 0;
        $date_fin->minute = 0;
        $date_fin->second = 0;

        DB::beginTransaction();
        Visit::where('user_id', $merch->id)
            ->where('visit_date', '>=', $date_debut)
            ->where('visit_date', '<=', $date_fin)
            ->where('is_answered', false)
            ->where('is_answered_branding', false)
            ->where('is_answered_display', false)
            ->where('is_answered_online', false)
            ->where('is_answered_ilv', false)
            ->delete();
        DB::commit();

        return "ok";
    }

    public function uploadPlanning(Request $request, $id){
        $merch = User::find($id);
        if ($merch == null || !$merch->hasRole('Merch')) {
            return redirect('/');
        }

        $destinationPath = storage_path();
        $file= storage_path($merch->id . '.xlsx');

        if ($request->hasFile('planning_file')) {
            if ($request->file('planning_file')->isValid()) {
                if (file_exists($file)){
                    unlink($file);
                }
                $request->file('planning_file')->move($destinationPath, $merch->id . ".xlsx");
            }
        }

        return "ok";
    }
}