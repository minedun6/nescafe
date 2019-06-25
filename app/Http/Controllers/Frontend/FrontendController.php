<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\NetworkType;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\Access\Facades\Access;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        setlocale(LC_TIME, 'french');

        if (Access::hasRole('Administrator')) {

        } elseif (Access::hasRole('Visiteur') || Access::hasRole('Superviseur')) {
            return $this->visitorIndex();
        } elseif (Access::hasRole('Merch')) {
            return $this->merchIndex();
        }

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
            ->count();
        $total_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->count();

        $last_two_weeks = Carbon::now()->subWeeks(2)->setTime(0, 0, 0)->format('Y-m-d');
        $last_four_weeks = Carbon::now()->subWeeks(4)->setTime(0, 0, 0)->format('Y-m-d');
        $result_for_last_two_weeks = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
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
            ->groupBy('date')
            ->get();

        $day = Carbon::now()->subWeeks(2)->setTime(0, 0, 0);
        $dates1[] = array($day->formatLocalized('%A %d/%m'), 0);

        for ($i = 0; $i < 13; $i++) {
            $dates1[] = array($day->addDay()->formatLocalized('%A %d/%m'), 0);
        }
        $dates2 = $dates1;
        $dates3 = $dates1;
        foreach ($result_for_last_two_weeks as $visit_stat) {
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
            ->orderBy('anomalies', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->take(5)
            ->get();
        $ten_last_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->orderBy('updated_at', 'DESC')
            ->take(10)
            ->get();
        $pdvl_type = NetworkType::where('code', 'pdvl')->first();
        $pdvc_type = NetworkType::where('code', 'pdvc')->first();
        $franchise_type = NetworkType::where('code', 'franchise')->first();
        $boutique_type = NetworkType::where('code', 'boutique')->first();
        $boutiques_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '20')
            ->count();
        $pdvc_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '40')
            ->count();
        $pdvl_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '30')
            ->count();
        $franchises_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '20')
            ->count();
        $top_three_anomalies_for_boutique = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_franchise = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvl = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvc = Visit::where('visits.updated_at', '>', $last_fifteen_days)
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);

        $planned_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(visit_date,'%Y-%m-%d') as date"))
            ->whereBetween('visit_date', array($last_two_weeks, $date->format('Y-m-d')))
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
            ->count();

        $display_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_display', true)
            ->count();
        $online_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_online', true)
            ->count();
        $ilv_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_ilv', true)
            ->count();
        $branding_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered_branding', true)
            ->count();
        $daily_visits = DB::table('visits')
            ->select(DB::raw("count(*) as visits_count, DATE_FORMAT(updated_at,'%Y-%m-%d') as date"))
            ->whereBetween('updated_at', array($last_two_weeks, $date->format('Y-m-d')))
            ->where('is_answered', true)
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

        return view('frontend.index', array(
            'number_of_visits_this_month' => $number_of_visits_this_month,
            'number_of_visits_last_month' => $number_of_visits_last_month,
            'number_of_visits_last_fifteen_days' => $number_of_visits_last_fifteen_days,
            'number_of_visits_last_week' => $number_of_visits_last_week,
            'total_visits' => $total_visits,
            'top_five_anomalies' => $top_five_anomalies,
            'ten_last_visits' => $ten_last_visits,
            'top_three_anomalies_for_boutique' => $top_three_anomalies_for_boutique,
            'top_three_anomalies_for_franchise' => $top_three_anomalies_for_franchise,
            'top_three_anomalies_for_pdvl' => $top_three_anomalies_for_pdvl,
            'top_three_anomalies_for_pdvc' => $top_three_anomalies_for_pdvc,
            'boutiques_number_with_anomalies' => $boutiques_number_with_anomalies,
            'pdvc_number_with_anomalies' => $pdvc_number_with_anomalies,
            'pdvl_number_with_anomalies' => $pdvl_number_with_anomalies,
            'franchises_number_with_anomalies' => $franchises_number_with_anomalies,
            'branding_percent' => number_format($branding_percent, 2, '.', ''),
            'daily_percent' => number_format($daily_percent, 2, '.', ''),
            'ilv_percent' => number_format($ilv_percent, 2, '.', ''),
            'display_percent' => number_format($display_percent, 2, '.', ''),
            'online_percent' => number_format($online_percent, 2, '.', '')
        ));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('frontend.macros');
    }

    public function visitorIndex()
    {
        setlocale(LC_TIME, 'french');
        $current_user = Auth::user();
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
            ->count();
        $total_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->count();

        $ten_last_visits = Visit::where(function ($query) {
            $query->where('is_answered', true)
                ->orWhere('is_answered_display', true)
                ->orWhere('is_answered_branding', true)
                ->orWhere('is_answered_online', true)
                ->orWhere('is_answered_ilv', true);
        })
            ->orderBy('updated_at', 'DESC')
            ->take(10)
            ->get();
        $pdvl_type = NetworkType::where('code', 'pdvl')->first();
        $pdvc_type = NetworkType::where('code', 'pdvc')->first();
        $franchise_type = NetworkType::where('code', 'franchise')->first();
        $boutique_type = NetworkType::where('code', 'boutique')->first();
        $boutiques_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '20')
            ->count();
        $pdvc_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '40')
            ->count();
        $pdvl_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '30')
            ->count();
        $franchises_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('is_answered', true)
            ->where('anomalies', '>', '20')
            ->count();
        $top_three_anomalies_for_boutique = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);

        $top_three_anomalies_for_franchise = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvl = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);
        $top_three_anomalies_for_pdvc = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('is_answered', true)
            ->orderBy('anomalies', 'DESC')
            ->take(3)
            ->get(['visits.*']);

        javascript()->put([
        ]);

        return view('frontend.visitor.index', array(
            'number_of_visits_this_month' => $number_of_visits_this_month,
            'number_of_visits_last_month' => $number_of_visits_last_month,
            'number_of_visits_last_fifteen_days' => $number_of_visits_last_fifteen_days,
            'number_of_visits_last_week' => $number_of_visits_last_week,
            'total_visits' => $total_visits,
            'ten_last_visits' => $ten_last_visits,
            'top_three_anomalies_for_boutique' => $top_three_anomalies_for_boutique,
            'top_three_anomalies_for_franchise' => $top_three_anomalies_for_franchise,
            'top_three_anomalies_for_pdvl' => $top_three_anomalies_for_pdvl,
            'top_three_anomalies_for_pdvc' => $top_three_anomalies_for_pdvc,
            'boutiques_number_with_anomalies' => $boutiques_number_with_anomalies,
            'pdvc_number_with_anomalies' => $pdvc_number_with_anomalies,
            'pdvl_number_with_anomalies' => $pdvl_number_with_anomalies,
            'franchises_number_with_anomalies' => $franchises_number_with_anomalies
        ));
    }


    public function merchIndex()
    {
        setlocale(LC_TIME, 'french');
        $current_user = Auth::user();
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
        $boutiques_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $boutique_type->id)
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->where('anomalies', '>', '20')
            ->count();
        $pdvc_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvc_type->id)
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->where('anomalies', '>', '40')
            ->count();
        $pdvl_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $pdvl_type->id)
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->where('anomalies', '>', '30')
            ->count();
        $franchises_number_with_anomalies = Visit::whereBetween('visits.updated_at', array($last_fifteen_days, $date->format('Y-m-d H:i:s')))
            ->join('networks', 'networks.id', '=', 'visits.network_id')
            ->where('networks.type_id', $franchise_type->id)
            ->where('is_answered', true)
            ->where('user_id', $current_user->id)
            ->where('anomalies', '>', '20')
            ->count();
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

        return view('frontend.index', array(
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
            'boutiques_number_with_anomalies' => $boutiques_number_with_anomalies,
            'pdvc_number_with_anomalies' => $pdvc_number_with_anomalies,
            'pdvl_number_with_anomalies' => $pdvl_number_with_anomalies,
            'franchises_number_with_anomalies' => $franchises_number_with_anomalies,
            'branding_percent' => number_format($branding_percent, 2, '.', ''),
            'daily_percent' => number_format($daily_percent, 2, '.', ''),
            'ilv_percent' => number_format($ilv_percent, 2, '.', ''),
            'display_percent' => number_format($display_percent, 2, '.', ''),
            'online_percent' => number_format($online_percent, 2, '.', '')
        ));
    }
}
