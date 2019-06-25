<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Alerte;
use App\Models\Approvisionnement;
use App\Models\ILV;
use App\Models\ILVNetwork;
use App\Models\Network;
use App\Models\NetworkType;
use App\Models\Visit;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Photo;
use Intervention\Image\Facades\Image;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ILVController extends Controller
{

    public function index()
    {
        $ilvs = ILV::all();

        return view('frontend.ilvs.list', array(
            'ilvs' => $ilvs
        ));
    }

    public function create()
    {
        $network_types = NetworkType::all();

        return view('frontend.ilvs.add', array(
            'network_types' => $network_types
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $ilv = new ILV();
        $ilv->name = $request->name;
        $ilv->network_type_id = $request->network_type != '' ? $request->network_type : null;
        $ilv->target = $request->target != '' ? $request->target : null;
        $ilv->should_notify = $request->should_notify ? true : false;
        $date = \Carbon\Carbon::now();
        $timestamp = $date->timestamp;
        $uploaded_photo = Input::file('picture');
        if (!(substr($uploaded_photo->getMimeType(), 0, 5) == 'image')) {
            return redirect()->back()->withErrors(array(
                'error' => 'type de photo non pris en charge !!'
            ));
        } elseif ($uploaded_photo == null) {
            return redirect()->back()->withErrors(array(
                'error' => "L'image est obligatoire !!"
            ));
        }
        $picture = new Photo();
        $picture->type = 'ilv';
        $picture->path = '/photos/ilv/' . $timestamp . $uploaded_photo->getClientOriginalName();
        $picture->save();
        $ilv->photo_id = $picture->id;
        $img = Image::make($uploaded_photo->getRealPath());
        $img->save(public_path($picture->path));
        $img->save();
        $ilv->save();

        $appro = new Approvisionnement();
        $appro->ilv_id = $ilv->id;
        $appro->quantity = $request->initial_quantity;
        $appro->save();

        DB::commit();

        return redirect('/ilv/detail/' . $ilv->id);
    }

    public function show($id)
    {
        $ilv = ILV::find($id);
        if ($ilv == null) {
            return redirect()->back();
        }
        $network_types = NetworkType::all();
        $stock = Approvisionnement::where('ilv_id', $ilv->id)
            ->sum('quantity');
        $zones = Zone::all();
        return view('frontend.ilvs.detail', array(
            'ilv' => $ilv,
            'stock' => $stock,
            'network_types' => $network_types,
            'zones' => $zones
        ));
    }

    public function edit($id)
    {
        $network_types = NetworkType::all();
        $ilv = ILV::find($id);
        $stock = Approvisionnement::where('ilv_id', $ilv->id)
            ->sum('quantity');

        return view('frontend.ilvs.edit', array(
            'ilv' => $ilv,
            'network_types' => $network_types,
            'stock' => $stock
        ));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        $ilv = ILV::find($id);
        $ilv->name = $request->name;
        $ilv->network_type_id = $request->network_type != '' ? $request->network_type : null;
        $ilv->target = $request->target != '' ? $request->target : null;
        $ilv->should_notify = $request->should_notify ? true : false;
        $uploaded_photo = Input::file('picture');
        if ($uploaded_photo) {
            if (!(substr($uploaded_photo->getMimeType(), 0, 5) == 'image')) {
                return redirect()->back()->withErrors(array(
                    'error' => 'type de photo non pris en charge'
                ));
            } else {
                return redirect()->back()->withErrors(array(
                    'error' => "L'image est obligatoire !!"
                ));
            }
            $date = \Carbon\Carbon::now();
            $timestamp = $date->timestamp;
            $picture = new Photo();
            $picture->type = 'ilv';
            $picture->path = '/photos/ilv/' . $timestamp . $uploaded_photo->getClientOriginalName();
            $picture->save();
            $ilv->photo_id = $picture->id;
            $img = Image::make($uploaded_photo->getRealPath());
            $img->save(public_path($picture->path));
            $img->save();
        }
        $ilv->save();
        DB::commit();

        return redirect('/ilv/detail/' . $ilv->id);
    }

    public function destroy($id)
    {
    }

    public function paginate(Request $request)
    {
        $name = isset($request->search['value']) ? $request->search['value'] : '';
        if ($name != '') {
            $ilvs = ILV::where('name', 'like', '%' . $name . '%')
                ->paginate($request->length);
        } else {
            $ilvs = ILV::paginate($request->length);
        }
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->setTime(0, 0, 0)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';
        $ilvs_count = $ilvs->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $ilvs_count,
            "recordsFiltered" => $ilvs_count,
        ];
        $results ["data"] = [];

        foreach ($ilvs as $ilv) {
            $validated_visits = $ilv->history()->where('status', true);
            $all_visits = $ilv->history();
            if ($datedebut != '') {
                $validated_visits = $validated_visits->where('updated_at', '>', $datedebut);
                $all_visits = $all_visits->where('updated_at', '>', $datedebut);
            }
            if ($datefin != '') {
                $validated_visits = $validated_visits->where('updated_at', '<', $datefin);
                $all_visits = $all_visits->where('updated_at', '<', $datefin);
            }
            $validated_visits = $validated_visits->count();
            $all_visits = $all_visits->count() != 0 ? $all_visits->count() : 1;
            $percent = ($validated_visits * 100) / $all_visits;
            $stock = Approvisionnement::where('ilv_id', $ilv->id)
                ->sum('quantity');
            $results ["data"] [] = array(
                $ilv->name,
                $ilv->networkType ? $ilv->networkType->value : $ilv->target,
                $stock,
                number_format($percent, 2, '.', '') . ' %',
                '<a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/ilv/detail/" . $ilv->id) . '"><i
                                                        class="fa fa-info"></i> Détails</a>
                    <a class="btn btn-sm dark" id="btn-detail"
                                               href="' . url("/ilv/edit/" . $ilv->id) . '"><i
                                                        class="fa fa-edit"></i> edit</a>'
            );
        }

        return $results;
    }


    public function paginateHistory(Request $request, $id)
    {
        $name = isset($request->search['value']) ? $request->search['value'] : '';
        /*
         * select max date for each network
         */
        $sub_query = ILVNetwork::select(DB::raw('MAX(ilv_networks.updated_at) as m_date'), 'network_id')
            ->groupBy('ilv_networks.network_id')
            ->orderBy('ilv_networks.updated_at', 'DESC');
        /**
         * extract ilv network which her date equal to max date
         * and network_id = network_id selected before
         */
        $main_query = DB::table('ilv_networks as t1')
            ->select('t1.*')
            ->where('t1.ilv_id', $id)
            ->join(DB::raw("({$sub_query->toSql()}) as sub"), function ($join) {
                $join->on('sub.network_id', '=', 't1.network_id');
            })
            ->orderBy('t1.updated_at', 'DESC')
            ->where(DB::raw('sub.m_date'), '=', DB::raw('t1.updated_at'));

        /**
         * search for network by name
         */
        if ($main_query != '') {
            $main_query = $main_query->join('networks', 'networks.id', '=', 't1.network_id')
                ->where('networks.name', 'LIKE', '%' . $name . '%');
        }

        $ilv_networks = $main_query->paginate($request->length);

        $ilv_networks_count = $ilv_networks->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $ilv_networks_count,
            "recordsFiltered" => $ilv_networks_count,
        ];
        $results ["data"] = [];

        foreach ($ilv_networks as $ilv_network) {
            $ilv_network = ILVNetwork::find($ilv_network->id);
            $network = $ilv_network->network;
            if ($network->type != null) {
                if ($network->type->code == 'boutique' || $network->type->code == 'smart')
                    $network_type = 'boutique';
                elseif ($network->type->code == 'pdvc' || $network->type->code == 'pdvl' || $network->type->code == 'pdvg')
                    $network_type = 'pdv';
                else
                    $network_type = 'franchise';
            }

            $results ["data"] [] = array(
                $network ? '<a href="' . url('/network/detail/' . $network_type . '/' . $network->id) . '">' . $network->name . '</a>' : '',
                $ilv_network->updated_at ? $ilv_network->updated_at->format('d/m/Y') : '',
                $ilv_network->status == true ? '<span class="btn green">Disponible</span>' : '<span class="btn red">En rupture</span>'
            );
        }

        return $results;
    }

    public function paginateILVPerNetwork(Request $request, $id)
    {
        $name = isset($request->search['value']) ? $request->search['value'] : '';

        /**
         * select max date for each network
         */
        $sub_query = ILVNetwork::select(DB::raw('MAX(ilv_networks.updated_at) as m_date'), 'ilv_id')
            ->where('ilv_networks.network_id', $id)
            ->groupBy('ilv_networks.ilv_id')
            ->orderBy('ilv_networks.updated_at', 'DESC');

        /**
         * extract ilv network which her date equal to max date
         * and network_id = network_id selected before
         */
        $main_query = DB::table('ilv_networks as t1')
            ->select('t1.*')
            ->join(DB::raw("({$sub_query->toSql()}) as sub"), function ($join) {
                $join->on(DB::raw('sub.ilv_id'), '=', DB::raw('t1.ilv_id'));
            })
            ->mergeBindings($sub_query->getQuery())
            ->where(DB::raw('sub.m_date'), '=', DB::raw('t1.updated_at'))
            ->orderBy('t1.updated_at', 'DESC');

        /**
         * search for network by name
         */
        if ($name != '') {
            $main_query = $main_query->join('networks', 'networks.id', '=', 't1.network_id')
                ->where('networks.name', 'LIKE', '%' . $name . '%');
        }

        $ilv_networks = $main_query->paginate($request->length);
        $ilv_networks_count = $ilv_networks->total();
        $results = [
            "draw" => $request->draw,
            "recordsTotal" => $ilv_networks_count,
            "recordsFiltered" => $ilv_networks_count,
        ];
        $results ["data"] = [];
        foreach ($ilv_networks as $ilv_network) {
            $ilv_network = ILVNetwork::find($ilv_network->id);
            $ilv = $ilv_network->ilv;
            $results ["data"] [] = array(
                $ilv ? '<a href="' . url('/ilv/detail/' . $ilv->id) . '">' . $ilv->name . '</a>' : '',
                $ilv_network->updated_at ? $ilv_network->updated_at->format('d/m/Y') : '',
                $ilv_network->status == true ? '<span class="btn green">Disponible</span>' : '<span class="btn red">En rupture</span>'
            );
        }

        return $results;
    }

    public function ilvStats(Request $request, $id)
    {
        $zone = $request->zone != '' ? $request->zone : '';
        $datedebut = $request->datedebut != '' ? Carbon::createFromFormat('d/m/Y', $request->datedebut)->format('Y-m-d H:i:s') : '';
        $datefin = $request->datefin != '' ? Carbon::createFromFormat('d/m/Y', $request->datefin)->setTime(23, 59, 59)->format('Y-m-d H:i:s') : '';
        $network_type = $request->network_type != '' ? NetworkType::find($request->network_type) : '';

        $ilv_query = ILV::where('ilvs.id', $id)
            ->join('ilv_networks', 'ilv_networks.ilv_id', '=', 'ilvs.id')
            ->join('networks', 'networks.id', '=', 'ilv_networks.network_id');
        if ($zone != '') {
            $ilv_query = $ilv_query->join('cities', 'cities.id', '=', 'networks.city_id')
                ->join('zones', 'zones.id', '=', 'cities.zone_id')
                ->where('zones.value', 'LIKE', '%' . $zone . '%');
        }
        if ($datedebut != '') {
            $ilv_query = $ilv_query->where('ilv_networks.updated_at', '>', $datedebut);
        }
        if ($datefin != '') {
            $ilv_query = $ilv_query->where('ilv_networks.updated_at', '<', $datefin);
        }
        if ($network_type != '') {
            $ilv_query = $ilv_query->where('networks.type_id', '=', $network_type->id);
        }

        $validated_ilv = clone $ilv_query;
        $none_validated_ilv = clone $ilv_query;

        $validated_ilv = $validated_ilv->where('ilv_networks.status', true)
            ->count();

        $none_validated_ilv = $none_validated_ilv->where('ilv_networks.status', false)
            ->count();

        return [
            [
                "type" => "Rupture",
                "pourcentage" => $none_validated_ilv,
                "color" => "#FF0F00"
            ], [
                "type" => "Disponibilité",
                "pourcentage" => $validated_ilv,
                "color" => "#2A0CD0"
            ]
        ];
    }

    public function deactivate($id)
    {
        $ilv = ILV::destroy($id);

        return redirect('/ilv');
    }

}
