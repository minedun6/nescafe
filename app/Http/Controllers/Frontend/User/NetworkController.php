<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\CheckList;
use App\Models\City;
use App\Models\Network;
use App\Models\NetworkType;
use App\Models\PhotoCategory;
use App\Services\Access\Facades\Access;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
use App\Models\PDV;
use App\Models\Franchise;
use App\Models\Visit;
use App\Models\Photoset;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NetworkController extends Controller
{
    public function index($type)
    {
        if ($type == 'pdvc') {
            return view('frontend.network.pdv.list_classic');
        }
        if ($type == 'pdvg') {
            return view('frontend.network.pdv.list_g');
        }
        return view('frontend.network.' . $type . '.list');
    }

    public function create($type)
    {
        $data = [];
        if ($type == 'pdv') {
            $network_types = NetworkType::where('code', 'like', $type . '%')
                ->get();
            $data = ['network_types' => $network_types];
        }
        return view('frontend.network.' . $type . '.add', $data);
    }

    public function store(Request $request, $type)
    {
        $function_name = '_' . $type . 'Add';
        $input = Input::all();
        $network = call_user_func_array(array($this, $function_name), array(
            'input' => $input
        ));

        return redirect('/network/detail/' . $type . '/' . $network->id);
    }

    public function edit($type, $id)
    {
        $data = [];
        $network = Network::find($id);
        $data['network'] = $network;
        if ($type == 'pdv') {
            $network_types = NetworkType::where('code', 'like', $type . '%')
                ->get();
            $data['network_types'] = $network_types;
        }
        return view('frontend.network.' . $type . '.edit', $data);
    }

    public function update(Request $request, $type, $id)
    {
        $function_name = '_' . $type . 'Edit';
        $input = Input::all();
        $network = call_user_func_array(array($this, $function_name), array(
            'input' => $input, 'id' => $id
        ));

        return redirect('/network/detail/' . $type . '/' . $network->id);
    }

    public function show($type, $id)
    {
        $network = Network::find($id);
        $display_categories = [];
        $display_photo_sets = [];
        $online_categories = [];
        $online_photo_sets = [];
        $branding_categories = [];
        $branding_photo_sets = [];
        $display_visit = Visit::where('network_id', $network->id)
            ->where('is_answered_display', true)
            ->orderBy('updated_at', 'DESC')
            ->first();
        if ($display_visit) {
            $photo_sets = Photoset::where('visit_id', $display_visit->id)
                ->where('category', 'display')
                ->get();
            $photoCats = PhotoCategory::where('network_type_id', $display_visit->network->type_id)
                ->where('visit_type', 'display')
                ->get();
            foreach ($photo_sets as $photo_set) {
                $display_photo_sets[] = $photo_set;
            }
            foreach ($photoCats as $photoCat) {
                $display_categories [] = [
                    'code' => $photoCat->code,
                    'value' => $photoCat->value
                ];
            }
        }

        $branding_visit = Visit::where('network_id', $network->id)
            ->where('is_answered_branding', true)
            ->orderBy('updated_at', 'DESC')
            ->first();

        if ($branding_visit) {
            $photo_sets = Photoset::where('visit_id', $branding_visit->id)
                ->where('category', 'branding')
                ->get();
            $photoCats = PhotoCategory::where('network_type_id', $branding_visit->network->type_id)
                ->where('visit_type', 'branding')
                ->get();
            foreach ($photo_sets as $photo_set) {
                $branding_photo_sets[] = $photo_set;
            }
            foreach ($photoCats as $photoCat) {
                $branding_categories [] = [
                    'code' => $photoCat->code,
                    'value' => $photoCat->value
                ];
            }

        }
        $online_visit = Visit::where('network_id', $network->id)
            ->where('is_answered_online', true)
            ->orderBy('updated_at', 'DESC')
            ->first();
        if ($online_visit) {
            $photo_sets = Photoset::where('visit_id', $online_visit->id)
                ->where('category', 'online')
                ->get();
            $photoCats = PhotoCategory::where('network_type_id', $online_visit->network->type_id)
                ->where('visit_type', 'online')
                ->get();
            foreach ($photo_sets as $photo_set) {
                $online_photo_sets[] = $photo_set;
            }
            foreach ($photoCats as $photoCat) {
                $online_categories [] = [
                    'code' => $photoCat->code,
                    'value' => $photoCat->value
                ];
            }
        }

        $daily_visit = Visit::where('network_id', $network->id)
            ->where('is_answered', true)
            ->orderBy('updated_at', 'DESC')
            ->first();
        $visits_number = Visit::where('network_id', $network->id)
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->count();
        return view('frontend.network.' . $type . '.detail', array(
            'network' => $network,
            'daily_visit' => $daily_visit,
            'online_visit' => $online_visit,
            'display_visit' => $display_visit,
            'branding_visit' => $branding_visit,
            'display_categories' => $display_categories,
            'display_photo_sets' => $display_photo_sets,
            'online_categories' => $online_categories,
            'online_photo_sets' => $online_photo_sets,
            'branding_categories' => $branding_categories,
            'branding_photo_sets' => $branding_photo_sets,
            'visits_number' => $visits_number
        ));
    }

    public function paginate(Request $request, $type)
    {
        $networks = Collection::make();
        $networks_count = 0;
        if ($type == 'boutique' || $type == 'franchise') {
            $network_type = NetworkType::where('code', $type)
                ->first();
            $networks = DB::table('networks')
                ->select('networks.*', DB::raw('max(visits.updated_at) as last_visit'))
                ->leftJoin('visits', 'visits.network_id', '=', 'networks.id')
                ->join('cities', 'cities.id', '=', 'networks.city_id')
                ->where('networks.name', 'LIKE', "%" . $request->network . "%")
                ->where('cities.name', 'LIKE', "%" . $request->city . "%")
                ->where('cities.governorate', 'LIKE', "%" . $request->governorate . "%");

            if ($type == 'boutique') {
                $networks = $networks->where(function ($query) {
                    $query->where('networks.type_id', 1);
                    $query->orWhere('networks.type_id', 6);
                });
            } else {
                $networks = $networks->where('networks.type_id', $network_type->id);
            }
            $networks = $networks->groupBy('networks.id')
                ->orderBy('last_visit', 'DESC')
                ->paginate($request->length);

            $networks_count = $networks->total();
        } else {
            $network_types = NetworkType::where('code', 'like', $type . '%')
                ->get();
            $type_ids = [];
            foreach ($network_types as $net_type) {
                $type_ids [] = $net_type->id;
            }

            $networks = DB::table('networks')
                ->select('networks.*', DB::raw('max(visits.updated_at) as last_visit'))
                ->leftJoin('visits', 'visits.network_id', '=', 'networks.id')
                ->join('cities', 'cities.id', '=', 'networks.city_id')
                ->whereIn('networks.type_id', $type_ids)
                ->where('networks.name', 'LIKE', "%" . $request->network . "%")
                ->where('cities.name', 'LIKE', "%" . $request->city . "%")
                ->where('cities.governorate', 'LIKE', "%" . $request->governorate . "%")
                ->groupBy('networks.id')
                ->orderBy('last_visit', 'DESC')
                ->paginate($request->length);
            $networks_count = $networks->total();
        }

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $networks_count,
            "recordsFiltered" => $networks_count,
        ];
        $results ["data"] = [];
        if ($type == 'pdvc' || $type == 'pdvl' || $type == 'pdvg') {
            foreach ($networks as $network) {
                if ($network->city_id != null) {
                    $city = City::find($network->city_id);
                }
                $type = $network->type_id != null ? NetworkType::find($network->type_id) : null;
                $results ["data"][] = [
                    $network->last_visit != null ? Carbon::createFromFormat('Y-m-d H:i:s', $network->last_visit)->format('d/m/Y H:i') : '',
                    $network->code,
                    $network->name,
                    $network->responsible,
                    $type != null ? $type->value : '',
                    $network->phone,
                    $city != null ? $city->name : '',
                    $city != null ? $city->governorate : '',
                    '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/network/detail/pdv/" . $network->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>
                    <a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/network/edit/pdv/" . $network->id) . '"><i
                                                        class="fa fa-info"></i> edit</a>'

                ];
            }
        } else {
            foreach ($networks as $network) {
                if ($network->city_id != null) {
                    $city = City::find($network->city_id);
                }
                $results ["data"][] = [
                    $network->last_visit != null ? Carbon::createFromFormat('Y-m-d H:i:s', $network->last_visit)->format('d/m/Y H:i') : '',
                    $network->code,
                    $network->name,
                    $network->responsible,
                    $network->phone,
                    $city != null ? $city->name : '',
                    $city != null ? $city->governorate : '',
                    '<a class="btn btn-sm dark" id = "btn-detail"
                                           href = "' . url("/network/detail/" . $type . "/" . $network->id) . '" ><i
                                                    class="fa fa-info" ></i> Détails</a>
                    <a class="btn btn-sm dark" id = "btn-detail"
                                           href = "' . url("/network/edit/" . $type . "/" . $network->id) . '" ><i
                                                    class="fa fa-info" ></i > edit</a >'

                ];
            }
        }

        return $results;
    }

    private function _franchiseAdd($inputs)
    {
        $network = new Network();
        $network_type = NetworkType::where('code', 'franchise')
            ->first();
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        $franchise = new Franchise();
        $franchise->network_id = $network->id;
        $franchise->time = $inputs['time'];
        $franchise->time_sunday = $inputs['sunday_time'];
        $franchise->save();

        return $network;
    }

    private function _pdvAdd($inputs)
    {
        $network = new Network();
        $network_type = NetworkType::find($inputs['type_id']);
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        if ($network->city_id == null)
            $network->city_id = 48;
        $pdv = new PDV();
        if ($network_type->code == 'pdvc') {
            $pdv->category = 'classique';
        } else if ($network_type->code == 'pdvg') {
            $pdv->category = 'gold';
        } else if ($network_type->code == 'pdvl') {
            $pdv->category = 'labelise';
        }
        $pdv->network_id = $network->id;
        $pdv->sector = $inputs['sector'];
        $pdv->cds = $inputs['cds'];
        $pdv->save();

        if (Access::hasRole('Merch')) {
            $day = Carbon::today();
            $visit = new Visit();
            $visit->visit_date = $day;
            $visit->network_id = $network->id;
            $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
            $visit->user_id = Access::user()->id;

            $visit->type = 'daily';
            $visit->save();
        }

        return $network;
    }

    private function _boutiqueAdd($inputs)
    {
        $network = new Network();
        $is_smart = $inputs['smart'] === 'true' ? true : false;
        if ($is_smart) {
            $network_type = NetworkType::where('code', 'smart')
                ->first();
        } else {
            $network_type = NetworkType::where('code', 'boutique')
                ->first();
        }
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        return $network;
    }

    private function _franchiseEdit($inputs, $id)
    {
        $network = Network::find($id);
        $network_type = NetworkType::where('code', 'franchise')
            ->first();
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        $franchise = $network->franchise;
        $franchise->network_id = $network->id;
        $franchise->time = $inputs['time'];
        $franchise->time_sunday = $inputs['sunday_time'];
        $franchise->save();

        return $network;
    }

    private function _boutiqueEdit($inputs, $id)
    {
        $network = Network::find($id);
        $is_smart = $inputs['smart'] === 'true' ? true : false;
        if ($is_smart) {
            $network_type = NetworkType::where('code', 'smart')
                ->first();
        } else {
            $network_type = NetworkType::where('code', 'boutique')
                ->first();
        }
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        return $network;
    }

    private function _pdvEdit($inputs, $id)
    {
        $network = Network::find($id);
        $network_type = NetworkType::find($inputs['type_id']);
        $network->type_id = $network_type->id;
        $network->name = $inputs['name'];
        $network->responsible = $inputs['responsible'];
        $network->phone = $inputs['phone1'];
        $network->phone2 = $inputs['phone2'];
        $network->land_line = $inputs['land_line'];
        $network->address = $inputs['address'];
        $network->code = $inputs['code'];
        $network->city_id = $inputs['city_id'] != "" && $inputs['town'] != "" ? $inputs['city_id'] : null;
        $network->postal_code = $inputs['postal_code'];
        $network->save();

        $pdv = $network->pdv;
        if ($network_type->code == 'pdvc') {
            $pdv->category = 'classique';
        } else if ($network_type->code == 'pdvg') {
            $pdv->category = 'gold';
        } else if ($network_type->code == 'pdvl') {
            $pdv->category = 'labelise';
        }
        $pdv->network_id = $network->id;
        $pdv->sector = $inputs['sector'];
        $pdv->cds = $inputs['cds'];
        $pdv->save();

        return $network;
    }

    public function networkAutoComplete(Request $request)
    {
        $network_name = $request->network;
        $zone = $request->zone;
        $network_type_id = $request->network_type;
        $results = [];
        if ($network_name != '') {
            $query = Network::where('networks.name', 'LIKE', '%' . $network_name . '%');
            if ($zone != '') {
                $query = $query->join('cities', 'cities.id', '=', 'networks.city_id')
                    ->join('zones', 'zones.id', '=', 'cities.zone_id')
                    ->where('zones.value', 'LIKE', '%' . $zone . '%');
            }
            if ($network_type_id != '') {
                $query = $query->where('type_id', '=', $network_type_id);
            }
            $networks = $query->get();
            foreach ($networks as $network) {
                $results[] = $network->name;
            }
        }

        return $results;
    }

    public function getVisitsPerNetwork(Request $request, $id)
    {
        $visits = Visit::where('network_id', $id)
            ->where(function ($query) {
                $query->where('is_answered', true)
                    ->orWhere('is_answered_branding', true)
                    ->orWhere('is_answered_display', true)
                    ->orWhere('is_answered_online', true)
                    ->orWhere('is_answered_ilv', true);
            })
            ->orderBy('updated_at', 'DESC')
            ->paginate($request->length);
        $data = [];
        foreach ($visits as $visit) {
            $visit->is_answered ? $b1 = 'green-jungle' : $b1 = 'dark';
            $visit->is_answered_branding ? $b2 = 'green-jungle' : $b2 = 'dark';
            $visit->is_answered_display ? $b3 = 'green-jungle' : $b3 = 'dark';
            $visit->is_answered_online ? $b4 = 'green-jungle' : $b4 = 'dark';
            $visit->is_answered_ilv ? $b5 = 'green-jungle' : $b5 = 'dark';
            $data[] = array(
                $visit->updated_at ? $visit->updated_at->format('d/m/Y') : '',
                '<center><span class="badge  badge-danger">' . $visit->anomalies . ' %</span></center>',
                '<center><span class="badge  badge-success">' . $visit->bmerch . ' %</span></center>',
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

        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $visits->total(),
            "recordsFiltered" => $visits->total(),
            "data" => $data
        ];

        return $results;
    }

}
