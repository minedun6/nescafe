<?php

namespace App\Http\Controllers\API\v2;

use App\Models\Access\User\User;
use App\Models\ILV;
use App\Models\ILVNetwork;
use App\Models\Note;
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
use App\Models\Alerte;

class ILVAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getILVList()
    {
        $ilvs = ILV::all();
        return $ilvs;
    }

    public function addILVVisit(Request $request)
    {
        $etats = $request->json()->all();
        if (sizeof($etats) > 0) {
            DB::beginTransaction();
            $visit = Visit::find($etats[0]['visit_id']);
            if ($visit == null){
                Log::notice('[API v2] Error in ILV, invalid visit id ' . $etats[0]['visit_id'] . ' sent from : '. Access::user()->name);
                abort(406, 'Invalid visit id');
            }
            foreach ($etats as $etat) {
                $ilv_network = ILVNetwork::where('visit_id', $visit->id)
                    ->where('ilv_id', $etat['ilv_id'])
                    ->first();
                if ($ilv_network == null){
                    $ilv_network = new ILVNetwork();
                    $ilv_network->visit_id = $visit->id;
                    $ilv_network->network_id = $etat['network_id'];
                    $ilv_network->ilv_id = $etat['ilv_id'];
                    $ilv_network->status = $etat['status'];

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
                        }
                    }
                }
            }
            $visit->is_answered_ilv = true;
            $visit->save();

            DB::commit();
        }

        return response()->json(['response' => 'ok']);
    }

}
