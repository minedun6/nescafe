<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\Access\User\User;
use  App\Models\Visit;
use App\Models\CheckList;
use  App\Models\Network;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

/**
 * Class UserRoleSeeder
 */
class Dimassi0404Seeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        //DB::table('visits')->truncate();


        //Seed pour les boutiques
        $results = Excel::selectSheetsByIndex(0)->load('storage/dimassi.xlsx', function($reader) {})->get();
        $rows = $results->toArray();

        $date_debut = Carbon::create(2016, 4, 4, 0, 0, 0,'Africa/Tunis');

        foreach ($rows as $row) {
            if($row['outlet'] != null){
                $day = $date_debut->copy()->addDay($row['w1']);
                $visit = new Visit();
                $visit->visit_date = $day;
                $networks = Network::where('name', $row['outlet'])->get();
                $network = null;
                foreach ($networks as $n){
                    if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat']))) {
                        $network = $n;
                        break;
                    }
                }
                if($network == null){
                    $network = Network::where('name', $row['outlet'])->first();
                }
                $visit->network_id = $network->id;
                $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
                $visit->user_id = 12;

                $visit->type = 'daily';
                $visit->save();
                $visit = $visit->replicate();
                $visit->type = 'branding';
                $visit->save();
                $visit = $visit->replicate();
                $visit->type = 'display';
                $visit->save();
            }

            if($row['outlet2'] != null){
                $day = $date_debut->copy()->addDay(7 + $row['w1']);
                $visit = new Visit();
                $visit->visit_date = $day;
                $networks = Network::where('name', $row['outlet2'])->get();
                $network = null;
                foreach ($networks as $n){
                    if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat2']))) {
                        $network = $n;
                        break;
                    }
                }

                if($network == null){
                    $network = Network::where('name', $row['outlet2'])->first();
                }
                $visit->network_id = $network->id;
                $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
                $visit->user_id = 12;

                $visit->type = 'daily';
                $visit->save();
                $visit = $visit->replicate();
                $visit->type = 'branding';
                $visit->save();
                $visit = $visit->replicate();
                $visit->type = 'display';
                $visit->save();
            }

        }


        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}