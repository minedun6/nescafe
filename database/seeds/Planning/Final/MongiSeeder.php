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
class MongiSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::beginTransaction();
        try {
            $results = Excel::selectSheetsByIndex(0)->load('storage/15.xlsx', function ($reader) {
            })->get();
            $rows = $results->toArray();

            $date_debut = Carbon::create(2016, 9, 12, 0, 0, 0,'Africa/Tunis');

            foreach ($rows as $row) {
                if ($row['outlet'] != null) {
                    $day = $date_debut->copy()->addDay($row['w1']);
                    $visit = new Visit();
                    $visit->visit_date = $day;
                    $networks = Network::where('name', $row['outlet'])->get();
                    $network1 = null;
                    $network2 = null;
                    $network3 = null;
                    $network = null;
                    foreach ($networks as $n) {
                        if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat']))
                            && strtolower(trim($n->type->code)) == strtolower(trim($row['type']))
                            && strtolower(trim($n->city->delegation)) == strtolower(trim($row['delegation']))
                        ) {
                            $network1 = $n;
                            break;
                        } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat']))
                            && strtolower(trim($n->type->code)) == strtolower(trim($row['type']))
                        ) {
                            $network2 = $n;
                        } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat']))) {
                            $network3 = $n;
                        }
                    }
                    if ($network1 != null) {
                        $network = $network1;
                    } else if ($network2 != null) {
                        $network = $network2;
                    } else if ($network3 != null) {
                        $network = $network3;
                    } else {
                        $network = Network::where('name', $row['outlet'])->first();
                    }
                    if ($network == null) {
                        echo $row['outlet'];
                        echo " n'existe pas ! \r\n";
                    }
                    $visit->network_id = $network->id;
                    $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
                    $visit->user_id = 15;

                    $visit->type = 'daily';
                    $visit->save();
                }

                if ($row['outlet2'] != null) {
                    $day = $date_debut->copy()->addDay(7 + $row['w1']);
                    $visit = new Visit();
                    $visit->visit_date = $day;
                    $networks = Network::where('name', $row['outlet2'])->get();
                    $network1 = null;
                    $network2 = null;
                    $network3 = null;
                    $network = null;
                    foreach ($networks as $n) {
                        if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat2']))
                            && strtolower(trim($n->type->code)) == strtolower(trim($row['type2']))
                            && strtolower(trim($n->city->delegation)) == strtolower(trim($row['delegation2']))
                        ) {
                            $network1 = $n;
                            break;
                        } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat2']))
                            && strtolower(trim($n->type->code)) == strtolower(trim($row['type2']))
                        ) {
                            $network2 = $n;
                        } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row['gouvernorat2']))) {
                            $network3 = $n;
                        }
                    }
                    if ($network1 != null) {
                        $network = $network1;
                    } else if ($network2 != null) {
                        $network = $network2;
                    } else if ($network3 != null) {
                        $network = $network3;
                    } else {
                        $network = Network::where('name', $row['outlet2'])->first();
                    }
                    if ($network == null) {
                        echo $row['outlet2'];
                        echo " n'existe pas ! \r\n";
                    }
                    $visit->network_id = $network->id;
                    $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
                    $visit->user_id = 15;

                    $visit->type = 'daily';
                    $visit->save();
                }

            }
        } catch (Exception $e) {
            //echo $e;
            DB::rollBack();
        }

        DB::commit();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}