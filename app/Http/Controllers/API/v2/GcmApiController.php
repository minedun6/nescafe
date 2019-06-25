<?php

namespace App\Http\Controllers\API\v2;

use App\Jobs\sendPushNotification;
use App\Models\Access\User\User;
use App\Models\GCM;
use App\Services\Access\Facades\Access;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GcmAPIController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['sendTestPush']]);
    }

    public function registerDevice(Request $request)
    {
        $data = $request->json()->all();
        $user = Access::user();

        DB::beginTransaction();

        $gcm = GCM::where('user_id', $user->id)->first();
        if (!$gcm) {
            $gcm = new GCM();
            $gcm->user_id = $user->id;
        }
        $gcm->token = $data['gcm_token'];
        $gcm->save();

        DB::commit();
        Log::info('[API v2] GCM Token received from : '. Access::user()->name);
        return response()->json(['response' => 'ok']);
    }

    public function sendTestPush(){
        $gcm = GCM::find(1);
        //$token = 'd8hnqkogD5E:APA91bFgVT2VLBzRZtrHIYmxZIXnsd3UlARUNN4JnkHSOtmy93tc1xKaTxh2WRdjl4elBb9CNcZiHiHhGbSc0G8aRY_8HlLJzCq9TDNczKo6olg7bDrY_A0xzmA-ujFTMh5KgOjkWSK1';
        $this->dispatch(new sendPushNotification($gcm->token, 'test from Ghassen', 6));
    }

}
