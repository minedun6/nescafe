<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Access\User\User;
use App\Models\Answer;
use App\Models\CheckList;
use App\Models\City;
use App\Models\Task;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Models\Access\Role\Role;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Network;
use App\Models\Visit;

use App\Models\NetworkType;
use Carbon\Carbon;


class StatsController extends Controller
{
    public function checklists()
    {
        $zones = Zone::all();
        return view('frontend.stats.checklists', array(
            'zones' => $zones
        ));
    }

    public function searchForChecklists(Request $request, $type)
    {
        switch ($type) {
            case 'boutique':
                $checklist_type = CheckList::where('code', 'CLB')->first();
                break;
            case 'franchise':
                $checklist_type = CheckList::where('code', 'CLF')->first();
                break;
            case 'pdvc':
                $checklist_type = CheckList::where('code', 'CLPC')->first();
                break;
            case 'pdvl':
                $checklist_type = CheckList::where('code', 'CLPL')->first();
                break;
            case 'smart':
                $checklist_type = CheckList::where('code', 'CLS')->first();
                break;
            default:
                $checklist_type = '';
                break;
        }

        $zone = $request->zone != '' ? $request->zone : '';
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';

        if ($checklist_type != '') {
            $tasks_query = Task::where('tasks.check_list_id', $checklist_type->id)
                ->join('answers', 'answers.task_id', '=', 'tasks.id');
            if ($datedebut != '') {
                $tasks_query = $tasks_query->where('answers.updated_at', '>=', $datedebut);
            }
            if ($datefin != '') {
                $tasks_query = $tasks_query->where('answers.updated_at', '<=', $datefin);
            }
            if ($zone != '') {
                $tasks_query = $tasks_query->join('visits', 'visits.id', '=', 'answers.visit_id')
                    ->join('networks', 'networks.id', '=', 'visits.network_id')
                    ->join('cities', 'cities.id', '=', 'networks.city_id')
                    ->join('zones', 'zones.id', '=', 'cities.zone_id')
                    ->where('zones.value', 'LIKE', '%' . $zone . '%');
            }

            $tasks = $tasks_query
                ->select(
                    'tasks.*',
                    DB::raw("(COUNT(IF(answers.value = 'ok',1,null))*100)/(COUNT(IF(answers.value = 'ko',1,null))+COUNT(IF(answers.value = 'ok',1,null))) as bmerch"),
                    DB::raw("(COUNT(IF(answers.value = 'ko',1,null))*100)/(COUNT(IF(answers.value = 'ko',1,null))+COUNT(IF(answers.value = 'ok',1,null))) as anomalies")
                )
                ->orderBy('anomalies', 'DESC')
                ->groupBy('tasks.id')
                ->paginate($request->length);
        }


        $tasks_result = [];
        foreach ($tasks as $index => $task) {
            $tasks_result[$index][] = $task->taskSubCategory ? ($task->taskSubCategory->taskCategory ? $task->taskSubCategory->taskCategory->name : '') : '';
            $tasks_result[$index][] = $task->taskSubCategory ? $task->taskSubCategory->name : '';
            $tasks_result[$index][] = $task->description;
            $tasks_result[$index][] = '<center><span class="badge  badge-success">' . number_format($task->bmerch, 2, '.', '') . ' %</span></center>';
            $tasks_result[$index][] = '<center><span class="badge  badge-danger">' . number_format($task->anomalies, 2, '.', '') . ' %</span></center>';
            $tasks_result[$index][] = '<center><a class="btn btn-sm dark" id="btn-detail"
                                           href="' . route('stats.details.checklists', ['id' => $task->id]) . '"><i
                                                    class="fa fa-info"></i> Stats</a></center>';
        }

        $total = $tasks->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $tasks_result
        ];

        return $results;
    }


    public function visites()
    {
        $merchs = Role::where('name', 'Merch')->first()->users()->get();
        $network_types = NetworkType::all();
        $zones = Zone::all();
        return view('frontend.stats.visites', array(
            'merchs' => $merchs,
            'network_types' => $network_types,
            'zones' => $zones
        ));
    }

    public function searchForVisits(Request $request)
    {
        $network_criteria = [];
        $network = $request->network != '' ? $request->network : '';
        $zone = $request->zone != '' ? $network_criteria['cities.zone'] = $request->zone : '';
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';
        $merch_id = $request->merch != '' ? $request->merch : '';
        $network_type = $request->network_type != '' ? $request->network_type : '';
        $network_types_id = [];
        if ($network_type) {
            if (is_numeric($network_type)) {
                $network_type = NetworkType::find($request->network_type);
                if ($network_type) {
                    $network_types_id [] = $network_type->id;
                }
            } else {
                if ($network_type == 'vi') {
                    $network_types = NetworkType::where('code', 'LIKE', '%pdvl%')
                        ->orWhere('code', 'LIKE', '%pdvc%')
                        ->get();
                } elseif ($network_type == 'vd') {
                    $network_types = NetworkType::where('code', 'LIKE', '%boutique%')
                        ->orWhere('code', 'LIKE', '%franchise%')
                        ->orWhere('code', 'LIKE', '%smart%')
                        ->get();
                }

                if ($network_types) {
                    foreach ($network_types as $one_type) {
                        $network_types_id [] = $one_type->id;
                    }
                }
            }

        }
        $query = Visit::select('visits.*')
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->orderBy('visits.updated_at', 'DESC');
        if ($network_type != '') {
            $query = $query->whereIn('networks.type_id', $network_types_id);
        }
        if ($datedebut != '') {
            $query = $query->where('visits.updated_at', '>=', $datedebut);
        }
        if ($datefin != '') {
            $query = $query->where('visits.updated_at', '<=', $datefin);
        }
        if ($merch_id != '') {
            $query->where('user_id', $merch_id);
        }
        if ($network != '') {
            $query = $query->where('networks.name', 'LIKE', '%' . $network . '%');
        }
        if ($zone != '') {
            $query = $query->join('cities', 'cities.id', '=', 'networks.city_id')
                ->join('zones', 'zones.id', '=', 'cities.zone_id')
                ->where('zones.value', 'LIKE', '%' . $zone . '%');
        }
        $anomalies_query = clone $query;
        $visits_for_anomalies = $anomalies_query->get();
        $anomalies_percent = 0;
        foreach ($visits_for_anomalies as $visit) {
            $anomalies_percent += $visit->anomalies;
        }
        $visits = $query->paginate($request->length);
        $total = $visits->total();

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total
        ];
        $results['data'] = array();
        foreach ($visits as $visit) {
            $visit->is_answered ? $b1 = 'green-jungle' : $b1 = 'dark';
            $visit->is_answered_branding ? $b2 = 'green-jungle' : $b2 = 'dark';
            $visit->is_answered_display ? $b3 = 'green-jungle' : $b3 = 'dark';
            $visit->is_answered_online ? $b4 = 'green-jungle' : $b4 = 'dark';
            $visit->is_answered_ilv ? $b5 = 'green-jungle' : $b5 = 'dark';
            $results["data"][] = array(
                $visit->updated_at->format('d/m/Y H:i'),
                $visit->network ? $visit->network->name : '',
                $visit->network ? $visit->network->type->value : '',
                $visit->network ? $visit->network->city->zone->value : '',
                $visit->user->name,
                '<a class="btn btn-sm ' . $b1 . '" id="btn-detail" title="Détail visite quotidienne" data-toggle="tooltip" data-placement="top"
                                           href="' . url("visits/" . "daily" . "/" . $visit->id) . '"><i
                                                    class="fa fa-calendar"></i></a>
                <a class="btn btn-sm ' . $b2 . '" id="btn-detail" title="Détail visite branding"
                                           href="' . url("visits/" . "branding" . "/" . $visit->id) . '"><i
                                                    class="fa fa-registered"></i></a>
                <a class="btn btn-sm ' . $b3 . '" id="btn-detail" title="Détail visite display"
                                           href="' . url("visits/" . "display" . "/" . $visit->id) . '"><i
                                                    class="fa fa-tv"></i></a>
                <a class="btn btn-sm ' . $b4 . '" id="btn-detail" title="Détail visite online"
                                           href="' . url("visits/" . "online" . "/" . $visit->id) . '"><i
                                                    class="fa fa-map-o"></i></a>' .
                '<a class="btn btn-sm ' . $b5 . '" id="btn-detail" title="Détail visite ilv"
                               href="' . url("visits/" . "ilv" . "/" . $visit->id) . '"><i
                                        class="icon-basket"></i></a>'

            );
        }
        $total = $total != 0 ? $total : 1;
        $results["anomalies"] = number_format(($anomalies_percent / $total), 2, '.', '');
        return $results;
    }


    public function Merchandiser()
    {
        return view('frontend.stats.merchandiser');
    }

    public function paginateMerchandisers(Request $request)
    {

        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';

        $merchs = Role::where('name', 'Merch')->first()->users()->paginate($request->length);

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $merchs->total(),
            "recordsFiltered" => $merchs->total(),
        ];

        $results['data'] = array();
        foreach ($merchs as $merch) {
            $total_visits = Visit::where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
                ->where('user_id', $merch->id);
            $anomalies_query = Visit::select(DB::raw('AVG(anomalies) as anomalies'))
                ->where('is_answered', true)
                ->where('user_id', $merch->id);

            if ($datedebut != '') {
                $total_visits = $total_visits->where('visits.updated_at', '>=', $datedebut);
                $anomalies_query = $anomalies_query->where('visits.updated_at', '>=', $datedebut);
            }
            if ($datefin != '') {
                $total_visits = $total_visits->where('visits.updated_at', '<=', $datefin);
                $anomalies_query = $anomalies_query->where('visits.updated_at', '<=', $datefin);
            }
            $total_visits = $total_visits->count();
            $anomalies_query = $anomalies_query->first();
            $results['data'][] = array(
                $merch->name,
                $merch->email,
                $merch->zone ? $merch->zone->value : '',
                $total_visits,
                '<center><span class="badge  badge-danger">' . number_format($anomalies_query->anomalies, 2, '.', '') . ' %</span></center>',
                '<center><a class="btn btn-sm dark" id="btn-detail"
                                           href="' . route('profile.merchandiser', ['id' => $merch->id]) . '"><i
                                                    class="fa fa-info"></i> Profil</a></center>'
            );
        }

        return $results;
    }


    public function profile($id)
    {
        setlocale(LC_TIME, 'french');
        $current_user = User::find($id);
        $date = Carbon::now();

        $this_month = $date->format('Y-m');
        $number_of_visits_this_month = Visit::where('updated_at', 'like', '%' . $this_month . '%')
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('user_id', $current_user->id)
            ->count();
        $last_month = Carbon::now()->subMonth()->format('Y-m');
        $number_of_visits_last_month = Visit::where('updated_at', 'like', '%' . $last_month . '%')
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('user_id', $current_user->id)
            ->count();
        $last_fifteen_days_start_day = Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d H:i:s');
        $last_fifteen_days = Carbon::now()->subDays(15)->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $number_of_visits_last_fifteen_days = Visit::whereBetween('updated_at', array($last_fifteen_days_start_day, $date->format('Y-m-d H:i:s')))
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('user_id', $current_user->id)
            ->count();

        $last_week_start_day = Carbon::now()->startOfWeek()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $number_of_visits_last_week = Visit::whereBetween('updated_at', array($last_week_start_day, $date->format('Y-m-d H:i:s')))
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('user_id', $current_user->id)
            ->count();
        $total_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->where('user_id', $current_user->id)
            ->count();
        $networks_with_anomalies = Visit::where('anomalies', '>', 30)
            ->whereBetween('updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->where('is_answered', true)
            ->groupBy('network_id')
            ->where('user_id', $current_user->id)
            ->get();
        $network_number_with_anomalies = count($networks_with_anomalies);
        $last_two_weeks = Carbon::now()->subWeeks(2)->setTime(0, 0, 0)->format('Y-m-d');
        $last_four_weeks = Carbon::now()->subWeeks(4)->setTime(0, 0, 0)->format('Y-m-d');
        $result = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('visits.user_id', $current_user->id)
            ->groupBy('date')
            ->get();
        $result_for_last_four_weeks = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_four_weeks, $last_two_weeks))
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->where('visits.user_id', $current_user->id)
            ->groupBy('date')
            ->get();
        $day = Carbon::now()->subWeeks(2)->setTime(0, 0, 0);
        $dates1[] = array($day->formatLocalized('%A %d/%m'), 0);

        for ($i = 0; $i < 13; $i++) {
            $dates1[] = array($day->addDay()->formatLocalized('%A %d/%m'), 0);
        }
        $dates2 = $dates1;
        $dates3 = $dates1;
        foreach ($result as $visit_stat) {
            foreach ($dates1 as $key => $one_day) {
                if ($one_day[0] == Carbon::createFromFormat('Y-m-d', $visit_stat->date)->formatLocalized('%A %d/%m')) {
                    $dates1[$key][1] = $visit_stat->visits_count;
                }
            }
        }

        foreach ($result_for_last_four_weeks as $visit_stat) {
            foreach ($dates2 as $key => $one_day) {
                if ($one_day[0] == Carbon::createFromFormat('Y-m-d', $visit_stat->date)->addDays(14)->formatLocalized('%A %d/%m')) {
                    $dates2[$key][1] = $visit_stat->visits_count;
                }
            }
        }

        $top_five_anomalies = Visit::whereBetween('updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->orderBy('anomalies', 'DESC')
            ->take(5)
            ->get();
        $ten_last_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->where('user_id', $current_user->id)
            ->orderBy('updated_at', 'DESC')
            ->take(10)
            ->get();
        $pdvl_type = NetworkType::where('code', 'pdvl')->first();
        $pdvc_type = NetworkType::where('code', 'pdvc')->first();
        $franchise_type = NetworkType::where('code', 'franchise')->first();
        $boutique_type = NetworkType::where('code', 'boutique')->first();

        $top_three_anomalies_for_boutique = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('user_id', $current_user->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);

        $top_three_anomalies_for_franchise = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('user_id', $current_user->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvl = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('user_id', $current_user->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvc = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('user_id', $current_user->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);

        $planned_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(visit_date,'%Y-%m-%d') as date"))
            ->whereBetween('visit_date', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('user_id', $current_user->id)
            ->groupBy('date')
            ->get();

        foreach ($planned_visits as $visit_stat) {
            foreach ($dates3 as $key => $one_day) {
                if ($one_day[0] == Carbon::createFromFormat('Y-m-d', $visit_stat->date)->formatLocalized('%A %d/%m')) {
                    $dates3[$key][1] = $visit_stat->visits_count;
                }
            }
        }

        $all_planned_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(visit_date,'%Y-%m-%d') as date"))
            ->whereBetween('visit_date', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('user_id', $current_user->id)
            ->count();

        $display_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_display', true)
            ->where('user_id', $current_user->id)
            ->count();
        $online_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_online', true)
            ->where('user_id', $current_user->id)
            ->count();
        $ilv_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_ilv', true)
            ->where('user_id', $current_user->id)
            ->count();
        $branding_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_branding', true)
            ->where('user_id', $current_user->id)
            ->count();
        $daily_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->count();

        $branding_percent = $all_planned_visits != 0 ? ($branding_visits * 100) / $all_planned_visits : 0;
        $daily_percent = $all_planned_visits != 0 ? ($daily_visits * 100) / $all_planned_visits : 0;
        $ilv_percent = $all_planned_visits != 0 ? ($ilv_visits * 100) / $all_planned_visits : 0;
        $display_percent = $all_planned_visits != 0 ? ($display_visits * 100) / $all_planned_visits : 0;
        $online_percent = $all_planned_visits != 0 ? ($online_visits * 100) / $all_planned_visits : 0;

        javascript()->put([
            'visits_last_two_weeks' => $dates1,
            'visits_last_four_weeks' => $dates2,
            'planned_visits_two_weeks' => $dates3
        ]);

        return view('frontend.stats.profile', array(
            'number_of_visits_this_month' => $number_of_visits_this_month,
            'number_of_visits_last_month' => $number_of_visits_last_month,
            'number_of_visits_last_fifteen_days' => $number_of_visits_last_fifteen_days,
            'number_of_visits_last_week' => $number_of_visits_last_week,
            'total_visits' => $total_visits,
            'network_number_with_anomalies' => $network_number_with_anomalies,
            'top_five_anomalies' => $top_five_anomalies,
            'ten_last_visits' => $ten_last_visits,
            'top_three_anomalies_for_boutique' => $top_three_anomalies_for_boutique,
            'top_three_anomalies_for_franchise' => $top_three_anomalies_for_franchise,
            'top_three_anomalies_for_pdvl' => $top_three_anomalies_for_pdvl,
            'top_three_anomalies_for_pdvc' => $top_three_anomalies_for_pdvc,
            'merch' => $current_user,
            'branding_percent' => number_format($branding_percent, 2, '.', ''),
            'daily_percent' => number_format($daily_percent, 2, '.', ''),
            'ilv_percent' => number_format($ilv_percent, 2, '.', ''),
            'display_percent' => number_format($display_percent, 2, '.', ''),
            'online_percent' => number_format($online_percent, 2, '.', '')
        ));
    }


    public function network()
    {
        return view('frontend.stats.networks');
    }

    public function getZones(Request $request)
    {
        $zones = Zone::all();
        $network_type = $request->network_type;
        $zone_result = [];
        $date_fin = $request->date_debut ? Carbon::createFromFormat('d/m/Y', $request->date_debut) : Carbon::now();
        $date_debut = $request->date_fin ? Carbon::createFromFormat('d/m/Y', $request->date_fin) : Carbon::now()->subMonths(3)->setTime(0, 0, 0);

        foreach ($zones as $zone) {
            $visit = Visit::join('networks', 'networks.id', '=', 'visits.network_id')
                ->join('cities', 'cities.id', '=', 'networks.city_id')
                ->join('network_types', 'network_types.id', '=', 'networks.type_id')
                ->join('zones', 'zones.id', '=', 'cities.zone_id')
                ->where('network_types.code', 'LIKE', '%' . $network_type . '%')
                ->where('zones.id', $zone->id)
                ->where('visits.is_answered', true)
                ->where(function ($query) {
                    $query->where('visits.anomalies', '<>', 0)
                        ->orWhere('visits.bmerch', '<>', 0);
                })
                ->whereBetween('visits.updated_at', array(
                    $date_debut->format('Y-m-d H:i:s'),
                    $date_fin->format('Y-m-d H:i:s')
                ))
                ->select(DB::raw('AVG(visits.anomalies) as anomalies'))
                ->first();
            $zone_result[] = array(
                'name' => $zone->value,
                'y' => doubleval(number_format($visit->anomalies, 2, '.', '')),
                'drilldown' => $zone->id
            );
        }

        return $zone_result;

    }

    public function getDelegationPerZone(Request $request)
    {
        $zone_id = $request->zone_id;
        $date_fin = $request->date_debut ? Carbon::createFromFormat('d/m/Y', $request->date_debut) : Carbon::now();
        $date_debut = $request->date_fin ? Carbon::createFromFormat('d/m/Y', $request->date_fin) : Carbon::now()->subMonths(3)->setTime(0, 0, 0);
        $network_type = $request->network_type;
        if ($zone_id) {
            $zone = Zone::find($zone_id);
            $result['id'] = $zone->id;
            $result['name'] = $zone->value;
            $result['data'] = [];
            $cities = $zone->cities()
                ->groupBy('delegation')
                ->select('delegation')
                ->get();

            foreach ($cities as $city) {
                $visit = Visit::join('networks', 'networks.id', '=', 'visits.network_id')
                    ->join('network_types', 'network_types.id', '=', 'networks.type_id')
                    ->join('cities', 'cities.id', '=', 'networks.city_id')
                    ->where('cities.delegation', 'LIKE', '%' . $city->delegation . '%')
                    ->whereBetween('visits.updated_at', array(
                        $date_debut->format('Y-m-d H:i:s'),
                        $date_fin->format('Y-m-d H:i:s')
                    ))
                    ->where('network_types.code', 'LIKE', '%' . $network_type . '%')
                    ->where('visits.is_answered', true)
                    ->where(function ($query) {
                        $query->where('visits.anomalies', '<>', 0)
                            ->orWhere('visits.bmerch', '<>', 0);
                    })
                    ->select(DB::raw('AVG(visits.anomalies) as anomalies'))
                    ->first();
                $result['data'] [] = array(
                    $city->delegation,
                    doubleval(number_format($visit->anomalies, 2, '.', '')),
                );
            }
            return $result;
        }

        return [];
    }

    public function paginateNetworks(Request $request, $type)
    {
        $network_type = NetworkType::where('code', $type)->first();
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->setTime(0, 0, 0)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';
        $zone = $request->zone != '' ? $request->zone : '';
        $governorate = $request->gouvernerat != '' ? $request->gouvernerat : '';

        $network_name = $request->network != '' ? $request->network : '';
        $networks_query = Network::where('type_id', $network_type->id)
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('cities', 'cities.id', '=', 'networks.city_id')
            ->where('visits.is_answered', true);

        if ($network_name != '') {
            $networks_query = $networks_query->where('networks.name', 'LIKE', '%' . $network_name . '%');
        }
        if ($zone != null) {
            $networks_query = $networks_query->join('zones', 'zones.id', '=', 'cities.zone_id')
                ->where('zones.value', 'LIKE', '%' . $zone . '%');
        }
        if ($governorate != null) {
            $networks_query = $networks_query->where('cities.delegation', 'LIKE', '%' . $governorate . '%');
        }

        if ($datedebut != '') {
            $networks_query = $networks_query->where('visits.updated_at', '>', $datedebut);
        }
        if ($datefin != '') {
            $networks_query = $networks_query->where('visits.updated_at', '<', $datefin);
        }
        $networks_query = $networks_query->select('networks.*', DB::raw('AVG(visits.anomalies) as avg_anomalies'), DB::raw('AVG(visits.bmerch) as avg_bmerch'))
            ->where(function ($query) {
                $query->where('visits.anomalies', '<>', 0)
                    ->orWhere('visits.bmerch', '<>', 0);
            })
            ->groupBy('networks.id');
        $networks = $networks_query->paginate($request->length);
        $data = [];
        foreach ($networks as $network) {
            $data[] = array(
                $network->code,
                $network->name,
                $network->city ? $network->city->name : '',
                $network->city ? $network->city->delegation : '',
                $network->city ? $network->city->governorate : '',
                $network->city ? $network->city->zone->value : '',
                '<center><span class="badge  badge-success">' . number_format($network->avg_bmerch, 2, '.', '') . '</span></center>',
                '<center><span class="badge  badge-danger">' . number_format($network->avg_anomalies, 2, '.', '') . '</span></center>'
            );
        }
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $networks->total(),
            "recordsFiltered" => $networks->total(),
            "data" => $data
        ];

        return $results;
    }

    public function checklist($id)
    {
        $task = Task::find($id);

        if ($task == null) {
            return redirect()->back();
        }
        $zones = Zone::all();
        return view('frontend.stats.checklist', array(
            'task' => $task,
            'zones' => $zones
        ));
    }

    public function statsOnChecklist(Request $request, $id)
    {
        $task = Task::find($id);
        $zone = $request->zone != '' ? $request->zone : '';
        $network = $request->network != '' ? $request->network : '';
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->setTime(0, 0, 0)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';

        if ($task != '') {
            $tasks_query = Task::join('answers', 'answers.task_id', '=', 'tasks.id')
                ->join('visits', 'visits.id', '=', 'answers.visit_id')
                ->where('answers.task_id', $task->id)
                ->where('visits.is_answered', true)
                ->join('networks', 'networks.id', '=', 'visits.network_id');
            if ($datedebut != '') {
                $tasks_query = $tasks_query->where('answers.updated_at', '>=', $datedebut);
            }
            if ($network != '') {
                $tasks_query = $tasks_query->where('networks.name', 'LIKE', '%' . $network . '%');
            }
            if ($datefin != '') {
                $tasks_query = $tasks_query->where('answers.updated_at', '<=', $datefin);
            }
            if ($zone != '') {
                $tasks_query = $tasks_query
                    ->join('cities', 'cities.id', '=', 'networks.city_id')
                    ->join('zones', 'zones.id', '=', 'cities.zone_id')
                    ->where('zones.value', 'LIKE', '%' . $zone . '%');
            }

            if ($network != '') {
                $tasks = $tasks_query->select(
                    DB::raw("DATE_FORMAT(visits.updated_at, '%d-%m-%Y') AS date"),
                    DB::raw("(COUNT(IF(answers.value = 'ko',1,null))*100)/(COUNT(IF(answers.value = 'ko',1,null))+COUNT(IF(answers.value = 'ok',1,null))) as anomalies")
                );
            } else {
                $tasks = $tasks_query->select(
                    DB::raw("DATE_FORMAT(visits.updated_at, '%m-%Y') AS date"),
                    DB::raw("(COUNT(IF(answers.value = 'ko',1,null))*100)/(COUNT(IF(answers.value = 'ko',1,null))+COUNT(IF(answers.value = 'ok',1,null))) as anomalies")
                );
            }
            $tasks = $tasks->groupBy('date')
                ->orderBy('visits.updated_at', 'ASC')
                ->get();
        }

        $tasks_result = [];
        foreach ($tasks as $index => $task) {
            $tasks_result[] = array(
                $task->date,
                number_format($task->anomalies, 2, '.', '')
            );
        }

        return $tasks_result;
    }
}
