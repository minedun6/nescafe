<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Alerte;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AlertController extends Controller
{
    public function index()
    {
        $alertes = Alerte::orderBy('created_at', 'DESC')
            ->take(50)
            ->get();
        foreach ($alertes as $alerte) {
            if ($alerte->seen == false) {
                DB::beginTransaction();
                $alerte->seen = true;
                $alerte->save();
                DB::commit();
            }
        }
        return view('frontend.alert.list', array(
            'alertes' => $alertes
        ));
    }
}
