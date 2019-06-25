<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\City;
use  App\Models\Franchise;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class FranchiseSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('franchises')->truncate();

        //Seed pour les boutiques
        $results = Excel::selectSheetsByIndex(1)->load('storage/boutiques.xlsx', function($reader) {})->get();
        $rows = $results->toArray();

        $FranchiseNetworkTypeId = NetworkType::where('code', 'franchise')->first()->id;

        $i = 0;
        foreach ($rows as $row) {
            $city = City::where('name', $row['ville'])->first();
            if($city == null){
                $city = new City();
                $city->name = $row['ville'];
                $city->delegation = $row['ville'];
                $city->governorate = $row['gouvernorat'];
                $city->zone = $row['gouvernorat'];
                $city->save();
            }
            $i = $i + 1;
            $code = sprintf("F%04d", $i);
            $network = new Network();
            $network->code= $code;
            $network->name = $row['nom'];
            $network->responsible = $row['rf'];
            $network->address= $row['adresse'];
            $network->phone= $row['tel'];
            $network->phone2= '';
            $network->land_line= '';
            $network->postal_code= '';
            $network->type_id= $FranchiseNetworkTypeId;
            $network->city_id= $city->id;
            $network->save();

            $franchise = new Franchise();
            $franchise->time = $row['horaire'];
            $franchise->time_sunday = $row['horairedimanche'];
            $franchise->network_id = $network->id;

            $franchise->save();

        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}