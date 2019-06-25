<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Alerte;
use App\Models\ILV;
use App\Models\ILVNetwork;
use App\Models\PhotoCategory;
use App\Models\Photoset;
use App\Models\Visit;
use App\Models\Zone;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Access\Role\Role;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class VisitController extends Controller
{
    public function index($type)
    {
        $merchs = Role::where('name', 'Merch')->first()->users()->get();
        $zones = Zone::all();
        //Log::info('[Web] ' . $type .' Visits list request from : '. Access::user()->name);
        return view('frontend.' . $type . '.list', array(
            'merchs' => $merchs,
            'zones' => $zones
        ));
    }

    public function create()
    {
        return view('frontend.visits.add', array());

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function show($type, $id)
    {
        $visit = Visit::find($id);
        $data = ['visit' => $visit];
        $categories = [];
        $visit_photo_sets = [];
        $supervisor_note = false;
        if ($visit->is_answered || $visit->is_answered_branding || $visit->is_answered_display || $visit->is_answered_online || $visit->is_answered_ilv) {
            $supervisor_note = true;
        }
        $data['supervisor_note'] = $supervisor_note;
        switch ($type) {
            case 'daily':
                $is_answered = $visit->is_answered;
                break;
            case 'branding':
                $is_answered = $visit->is_answered_branding;
                break;
            case 'display':
                $is_answered = $visit->is_answered_display;
                break;
            case 'online':
                $is_answered = $visit->is_answered_online;
                break;
            case 'ilv':
                $is_answered = $visit->is_answered_ilv;
                break;
            default:
                $is_answered = false;
                break;
        }
        if ($type !== 'daily' && $type !== 'ilv') {
            if ($is_answered) {
                $photo_sets = Photoset::where('visit_id', $visit->id)
                    ->where('category', $type)
                    ->get();
                $photoCats = PhotoCategory::where('network_type_id', $visit->network->type_id)
                    ->where('visit_type', $type)
                    ->get();
                foreach ($photo_sets as $photo_set) {
                    $visit_photo_sets[] = $photo_set;
                }
                foreach ($photoCats as $photoCat) {
                    $categories [] = [
                        'code' => $photoCat->code,
                        'value' => $photoCat->value
                    ];
                }
            }
            $data['categories'] = $categories;
            $data['visit_photo_sets'] = $visit_photo_sets;
        }

        if ($type == 'ilv') {
            if ($is_answered) {
                $sub = ILVNetwork::orderBy('created_at', 'DESC');
                $ilv_networks = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                    ->mergeBindings($sub->getQuery())
                    ->where('visit_id', $id)
                    ->groupBy('ilv_id')
                    ->get();
                $ilvs = [];
                foreach ($ilv_networks as $ilv_network) {
                    $ilv = ILV::find($ilv_network->ilv_id);
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $ilv_network->created_at)->format('Y/m/d');
                    $status = $ilv_network->status == 1 ? true : false;
                    $ilvs [] = array(
                        'id' => $ilv ? $ilv->id : '',
                        'name' => $ilv ? $ilv->name : '',
                        'photo' => $ilv ? ($ilv->photo ? $ilv->photo->path : '') : '',
                        'date' => $date,
                        'status' => $status
                    );
                }
                $data['ilv_networks'] = $ilvs;
            } else {
                $network_type_id = $visit->network ? $visit->network->type->id : '';
                if ($visit->network) {
                    $network_type = $visit->network->type->code;
                    if ($network_type == 'franchise' || $network_type == 'boutique' || $network_type == 'smart') {
                        $ilvs = ILV::where('network_type_id', $network_type_id)
                            ->orWhere('target', 'VD')
                            ->orWhere('target', 'VDI')
                            ->get();
                    } else if ($network_type = 'pdvc' || $network_type == 'pdvl' || $network_type == 'pdvg') {
                        $ilvs = ILV::where('network_type_id', $network_type_id)
                            ->orWhere('target', 'VI')
                            ->orWhere('target', 'VDI')
                            ->get();
                    } else {
                        $ilvs = ILV::where('network_type_id', $network_type_id)
                            ->orWhere('target', 'VDI')
                            ->get();
                    }
                    $data['ilvs'] = $ilvs;
                }
            }
        }

        $can_edit = true;
        $now = Carbon::now();
        $visit_date = new Carbon($visit->updated_at);
        $visit_date->addDay(1);
        if ($visit_date < $now) {
            $can_edit = false;
        }
        $data['can_edit'] = $can_edit;

        return view('frontend.' . $type . '.detail', $data);
    }

    public function destroy($id)
    {

    }

    public function getPlanning()
    {
        $merchs = Role::where('name', 'Merch')->first()->users()->get();
        Log::info('[Web] Planning request from : ' . Access::user()->name);
        $zones = Zone::all();
        return view('frontend.planning.list', array(
            'merchs' => $merchs,
            'zones' => $zones
        ));
    }

    public function paginate(Request $request)
    {
        $generic_query = Visit::where('type', 'daily')
            ->where(function ($query) {
                $query->where('is_answered', false);
                    /*->orWhere('is_answered_branding', false)
                    ->orWhere('is_answered_display', false)
                    ->orWhere('is_answered_online', false)
                    ->orWhere('is_answered_ilv', false);*/
            })
            ->whereHas('network', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->network . "%")
                    ->whereHas('type', function ($q) use ($request) {
                        $q->where('value', 'LIKE', "%" . $request->type . "%");
                    })
                    ->whereHas('city', function ($q) use ($request) {
                        $q->join('zones', 'zones.id', '=', 'cities.zone_id')
                            ->where('zones.value', 'LIKE', "%" . $request->zone . "%");
                    });
            })
            ->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->merch . "%");
            });

        if ($request->datedebut != "" & $request->datefin != "") {
            $generic_query = $generic_query->where('visit_date', '>=', Carbon::createFromFormat("d/m/Y", $request->datedebut)->subDay())
                ->where('visit_date', '<', Carbon::createFromFormat("d/m/Y", $request->datefin));
        }

        if (Access::hasRole('Merch')) {
            $all_visits = $generic_query->where('user_id', Auth::user()->id)->get();

            $visits = $generic_query->where('user_id', Auth::user()->id)
                ->orderBy('visit_date', 'asc')
                ->paginate($request->length);
        } else {
            $all_visits = $generic_query->get();

            $visits = $generic_query->orderBy('visit_date', 'asc')
                ->paginate($request->length);
        }

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => count($all_visits),
            "recordsFiltered" => count($all_visits),
        ];
        $results["data"] = array();
        foreach ($visits as $visit) {
            $current_visit = Visit::find($visit->id);
            $current_visit->is_answered ? $b1 = 'green-jungle' : $b1 = 'dark';
            $current_visit->is_answered_branding ? $b2 = 'green-jungle' : $b2 = 'dark';
            $current_visit->is_answered_display ? $b3 = 'green-jungle' : $b3 = 'dark';
            $current_visit->is_answered_online ? $b4 = 'green-jungle' : $b4 = 'dark';
            $current_visit->is_answered_ilv ? $b5 = 'green-jungle' : $b5 = 'dark';
            $results["data"][] = array(
                $current_visit->visit_date->format('d/m/Y'),
                $current_visit->network ? $current_visit->network->name : null,
                $current_visit->network ? $current_visit->network->type->value : null,
                $current_visit->network ? $current_visit->network->city->zone->value : null,
                $current_visit->user->name,
                '<a class="btn btn-sm ' . $b1 . '" id="btn-detail" title="Détail visite quotidienne" data-toggle="tooltip" data-placement="top"
                                           href="' . url("visits/" . "daily" . "/" . $visit->id) . '"><i
                                                    class="fa fa-calendar"></i></a>
                <a class="btn btn-sm ' . $b4 . '" id="btn-detail" title="Détail visite online"
                                           href="' . url("visits/" . "online" . "/" . $visit->id) . '"><i
                                                    class="fa fa-map-o"></i></a>'
            );
        }

        return $results;
    }

    public function paginateVisits(Request $request, $type)
    {
        switch ($type) {
            case 'daily':
                $field = 'is_answered';
                break;
            case 'branding':
                $field = 'is_answered_branding';
                break;
            case 'display':
                $field = 'is_answered_display';
                break;
            case 'online':
                $field = 'is_answered_online';
                break;
            case 'ilv':
                $field = 'is_answered_ilv';
                break;
            default:
                $field = 'is_answered';
                break;
        }
        $generic_query = Visit::where($field, true)
            ->whereHas('network', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->network . "%")
                    ->whereHas('type', function ($q) use ($request) {
                        $q->where('value', 'LIKE', "%" . $request->type . "%");
                    })
                    ->whereHas('city', function ($q) use ($request) {
                        $q->join('zones', 'zones.id', '=', 'cities.zone_id')
                            ->where('zones.value', 'LIKE', "%" . $request->zone . "%");
                    });
            })
            ->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->merch . "%");
            });
        if ($request->datedebut != "" & $request->datefin != "") {
            $start = Carbon::createFromFormat("d/m/Y", $request->datedebut)->hour(0)->minute(0)->second(0);
            $end = Carbon::createFromFormat("d/m/Y", $request->datefin)->hour(23)->minute(59)->second(59);
            $generic_query = $generic_query->whereBetween('updated_at', [$start, $end]);
        }

        if (Access::hasRole('Merch')) {
            $all_visits = $generic_query->where('user_id', Auth::user()->id)->get();

            $visits = $generic_query->where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')
                ->paginate($request->length);
        } else {
            $all_visits = $generic_query->get();
            $visits = $generic_query->orderBy('updated_at', 'desc')
                ->paginate($request->length);
        }

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => count($all_visits),
            "recordsFiltered" => count($all_visits),
        ];
        $results["data"] = array();
        foreach ($visits as $visit) {
            $current_visit = Visit::find($visit->id);
            if ($type == 'daily') {
                $results["data"][] = array(
                    $current_visit->updated_at->format('d/m/Y H:i'),
                    $current_visit->network ? $current_visit->network->name : null,
                    $current_visit->network ? $current_visit->network->type->value : null,
                    $current_visit->network ? $current_visit->network->city->zone->value : null,
                    $current_visit->user->name,
                    '<center><span class="badge  badge-danger">' . $current_visit->anomalies . ' %</span></center>',
                    '<center><span class="badge  badge-success">' . $current_visit->bmerch . ' %</span></center>',
                    '<a class="btn btn-sm dark" id="btn-detail"
                                           href="' . url("visits/" . $type . "/" . $visit->id) . '"><i
                                                    class="fa fa-info"></i> Détails</a>'
                );
            } else {
                $results["data"][] = array(
                    $current_visit->updated_at->format('d/m/Y H:i'),
                    $current_visit->network ? $current_visit->network->name : null,
                    $current_visit->network ? $current_visit->network->type->value : null,
                    $current_visit->network ? $current_visit->network->city->zone->value : null,
                    $current_visit->user->name,
                    '<a class="btn btn-sm dark" id="btn-detail"
                                           href="' . url("visits/" . $type . "/" . $visit->id) . '"><i
                                                    class="fa fa-info"></i> Détails</a>'
                );
            }

        }

        return $results;
    }

    public function myDailyVisit()
    {
        $zones = Zone::all();
        $merchs = Role::where('name', 'Merch')->first()->users()->get();
        return view('frontend.mydaily.list', array(
            'merchs' => $merchs,
            'zones' => $zones
        ));
    }

    public function getTodayVisits(Request $request)
    {
        $today = Carbon::now();
        $date = $today->format('Y-m-d');

        $generic_query = Visit::where('updated_at', 'like', $date . '%')
            ->where(function ($query) {
                $query->where('is_answered', true);
                    /*->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);*/
            })
            ->whereHas('network', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->network . "%")
                    ->whereHas('type', function ($q) use ($request) {
                        $q->where('value', 'LIKE', "%" . $request->type . "%");
                    })
                    ->whereHas('city', function ($q) use ($request) {
                        $q->join('zones', 'zones.id', '=', 'cities.zone_id')
                            ->where('zones.value', 'LIKE', "%" . $request->zone . "%");
                    });
            })
            ->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%" . $request->merch . "%");
            });

        if (Access::hasRole('Merch')) {
            $visits_count = $generic_query->where('user_id', Auth::user()->id)->count();
            $visits = $generic_query->where('user_id', Auth::user()->id)
                ->orderBy('updated_at', 'DESC')
                ->paginate($request->length);
        } else {
            $visits_count = $generic_query->count();
            $visits = $generic_query->orderBy('updated_at', 'DESC')
                ->paginate($request->length);
        }
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $visits_count,
            "recordsFiltered" => $visits_count,
        ];
        $results["data"] = array();
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
                <a class="btn btn-sm ' . $b4 . '" id="btn-detail" title="Détail visite online"
                                           href="' . url("visits/" . "online" . "/" . $visit->id) . '"><i
                                                    class="fa fa-map-o"></i></a>'

            );

        }
        return $results;
    }

    public function createIlvVisit($id)
    {
        $visit = Visit::find($id);
        $network_type_id = $visit->network ? $visit->network->type->id : null;
        if ($visit->network) {
            $type = $visit->network->type->code;
            if ($type == 'franchise' || $type == 'boutique' || $type == 'smart') {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VD')
                    ->orWhere('target', 'VDI')
                    ->get();
            } else if ($type = 'pdvc' || $type == 'pdvl' || $type == 'pdvg') {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VI')
                    ->orWhere('target', 'VDI')
                    ->get();
            } else {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VDI')
                    ->get();
            }
        }
        return view('frontend.ilv.add', array(
            'visit' => $visit,
            'ilvs' => $ilvs
        ));
    }

    public function storeIlvVisit(Request $request, $id)
    {
        $visit = Visit::find($id);
        $ilvs_count = count($request->ilv_id);
        for ($i = 0; $i < $ilvs_count; $i++) {
            $ilv_id = $request->ilv_id[$i];
            if (isset($request->radio[$ilv_id])) {
                DB::beginTransaction();
                $ilv_network = new ILVNetwork();
                $ilv_network->ilv_id = $ilv_id;
                $ilv_network->network_id = $visit->network->id;
                $ilv_network->visit_id = $visit->id;
                $ilv_network->status = $request->radio[$ilv_id] == 'true' ? true : false;
                $ilv_network->save();
                if ($ilv_network->status == false) {
                    if ($ilv_network->ilv && $ilv_network->ilv->should_notify) {
                        $alert = new Alerte();
                        $message = 'ILV ' . $ilv_network->ilv->name . ' en rupture dans';
                        $network_type = $visit->network ? $visit->network->type : '';
                        if ($network_type != '' && ($network_type->code == 'smart' || $network_type->code == 'franchise' || $network_type->code == 'boutique')) {
                            $message .= ' la ' . $network_type->value . ' ' . $visit->network->name;
                        } else {
                            $message .= ' le ' . $network_type->value . ' ' . $visit->network->name;
                        }
                        $alert->message = $message;
                        $alert->target_type = 'ilv';
                        $alert->seen = false;
                        $alert->target_id = $ilv_network->ilv_id;
                        $alert->save();

                        $this->_sendEmail($alert);
                    }
                }
                DB::commit();
            }
        }
        DB::beginTransaction();
        $visit->is_answered_ilv = true;
        $visit->save();
        DB::commit();

        return redirect('visits/ilv/' . $visit->id);
    }

    public function editIlvVisit($id)
    {
        $visit = Visit::find($id);
        $sub = ILVNetwork::orderBy('created_at', 'DESC');
        $ilv_networks = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->mergeBindings($sub->getQuery())
            ->where('visit_id', $id)
            ->groupBy('ilv_id')
            ->get();
        $answered_ilvs = [];
        foreach ($ilv_networks as $ilv_network) {
            $ilv = ILV::find($ilv_network->ilv_id);
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $ilv_network->created_at)->format('Y/m/d');
            $status = $ilv_network->status == 1 ? true : false;
            $answered_ilvs [] = array(
                'id' => $ilv_network->id,
                'ilv_id' => $ilv->id,
                'name' => $ilv->name,
                'date' => $date,
                'status' => $status,
                'photo' => $ilv->photo ? $ilv->photo->path : ''
            );
        }

        $network_type_id = $visit->network ? $visit->network->type->id : '';
        if ($visit->network) {
            $type = $visit->network->type->code;
            if ($type == 'franchise' || $type == 'boutique' || $type == 'smart') {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VD')
                    ->orWhere('target', 'VDI')
                    ->get();
            } else if ($type = 'pdvc' || $type == 'pdvl' || $type == 'pdvg') {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VI')
                    ->orWhere('target', 'VDI')
                    ->get();
            } else {
                $ilvs = ILV::where('network_type_id', $network_type_id)
                    ->orWhere('target', 'VDI')
                    ->get();
            }
        }


        return view('frontend.ilv.edit', array(
            'visit' => $visit,
            'ilvs' => $ilvs,
            'visit_answered_ilvs' => $answered_ilvs
        ));
    }

    public function updateIlvVisit(Request $request, $id)
    {
        $visit = Visit::find($id);
        $ilv_networks_id_count = count($request->ilv_network_id);
        for ($i = 0; $i < $ilv_networks_id_count; $i++) {
            $ilv_network_id = $request->ilv_network_id[$i];
            if ($request->radio[$ilv_network_id] != null) {
                DB::beginTransaction();
                $ilv_network = ILVNetwork::find($request->ilv_network_id[$i]);
                $ilv_network->status = $request->radio[$ilv_network_id] == 'true' ? true : false;
                $ilv_network->save();
                if ($ilv_network->status == false) {
                    if ($ilv_network->ilv && $ilv_network->ilv->should_notify) {
                        $alert = new Alerte();
                        $message = 'ILV ' . $ilv_network->ilv->name . ' en rupture dans';
                        $network_type = $visit->network ? $visit->network->type : '';
                        if ($network_type != '' && ($network_type->code == 'smart' || $network_type->code == 'franchise' || $network_type->code == 'boutique')) {
                            $message .= ' la ' . $network_type->value . ' ' . $visit->network->name;
                        } else {
                            $message .= ' le ' . $network_type->value . ' ' . $visit->network->name;
                        }
                        $alert->message = $message;
                        $alert->target_type = 'ilv';
                        $alert->seen = false;
                        $alert->target_id = $ilv_network->ilv_id;
                        $alert->save();

                        $this->_sendEmail($alert);
                    }
                }
                DB::commit();
            }
        }

        $ilvs_count = count($request->ilv_id);
        for ($i = 0; $i < $ilvs_count; $i++) {
            $ilv_id = $request->ilv_id[$i];
            if (isset($request->item[$ilv_id])) {
                DB::beginTransaction();
                $ilv_network = new ILVNetwork();
                $ilv_network->ilv_id = $request->ilv_id[$i];
                $ilv_network->network_id = $visit->network->id;
                $ilv_network->visit_id = $visit->id;
                $ilv_network->status = $request->item[$ilv_id] == 'true' ? true : false;
                $ilv_network->save();
                if ($ilv_network->status == false) {
                    if ($ilv_network->ilv && $ilv_network->ilv->should_notify) {
                        $alert = new Alerte();
                        $message = 'ILV ' . $ilv_network->ilv->name . ' en rupture dans';
                        $network_type = $visit->network ? $visit->network->type : '';
                        if ($network_type != '' && ($network_type->code == 'smart' || $network_type->code == 'franchise' || $network_type->code == 'boutique')) {
                            $message .= ' la ' . $network_type->value . ' ' . $visit->network->name;
                        } else {
                            $message .= ' le ' . $network_type->value . ' ' . $visit->network->name;
                        }
                        $alert->message = $message;
                        $alert->target_type = 'ilv';
                        $alert->seen = false;
                        $alert->target_id = $ilv_network->ilv_id;
                        $alert->save();

                        $this->_sendEmail($alert);
                    }
                }
                DB::commit();
            }
        }

        return redirect('visits/ilv/' . $visit->id);
    }

    private function _sendEmail($alerte)
    {
        $setting = Setting::where('user_id', null)
            ->where('value', 'notify_mail')
            ->first();
        if ($setting && $setting->code = 'yes') {
            $supervisor_role = Role::where('name', 'Superviseur')->first();
            $admin_role = Role::where('name', 'Administrator')->first();
            $users_to_notify = [];
            foreach ($supervisor_role->users as $user) {
                $users_to_notify[] = $user;
            }
            foreach ($admin_role->users as $user) {
                $users_to_notify[] = $user;
            }
            foreach ($users_to_notify as $user) {
                Mail::send('frontend.emails.alert', ['alerte' => $alerte], function ($message) use ($user) {
                    $message->to($user->email, $user->name)->subject("Alerte d'orange Merchandiser !");
                });
            }
        } else {
            $settings = Setting::where('value', 'notify_mail')
                ->get();
            foreach ($settings as $setting) {
                if ($setting->code == 'yes') {
                    $user = User::find($setting->user_id);
                    Mail::send('frontend.emails.alert', ['alerte' => $alerte], function ($message) use ($user) {
                        $message->to($user->email, $user->name)->subject("Alerte d'orange Merchandiser !");
                    });
                }
            }
        }

        return true;
    }
}
