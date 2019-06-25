<?php

namespace App\Http\Controllers\Frontend\User;

use App\Models\Photoset;
use App\Models\Visit;
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

class LastVisitController extends Controller
{

    public function show($type, $id)
    {
        $visit = Visit::find($id);
        $network = $visit->network;
        $data = ['visit' => $visit, 'network' => $visit];
        $categories = [];
        $visit_photo_sets = [];

        switch ($type) {
            case 'daily': $is_answered = $visit->is_answered; break;
            case 'branding': $is_answered = $visit->is_answered_branding; break;
            case 'display': $is_answered = $visit->is_answered_display; break;
            case 'online': $is_answered = $visit->is_answered_online; break;
            default: $is_answered = false; break;
        }

        if ($type !== 'daily') {
            if ($is_answered) {
                $photo_sets = Photoset::where('visit_id', $visit->id)
                    ->where('category', $type)
                    ->get();
                foreach ($photo_sets as $photo_set) {
                    $visit_photo_sets[] = $photo_set;
                    $categories [] = [
                        'code' => $photo_set->photoCategory->code,
                        'value' => $photo_set->photoCategory->value
                    ];

                }
            }
            $data['categories'] = $categories;
            $data['photo_sets'] = $visit_photo_sets;
        }

        $can_edit = true;

        $now = Carbon::now();
        $visit_date = new Carbon($visit->updated_at);
        $visit_date->addDay(1);
        if ($visit_date < $now) {
            $can_edit = false;
        }
        $data['can_edit'] = $can_edit;

        return view('frontend.network.last_visits.last_' . $type, $data);
    }

}
