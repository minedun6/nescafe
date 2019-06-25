<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\City;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class NetworkSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('networks')->truncate();


        //Seed pour les boutiques
        $results = Excel::selectSheetsByIndex(0)->load('storage/boutiques.xlsx', function($reader) {})->get();
        $rows = $results->toArray();

        $BoutiqueNetworkTypeId = NetworkType::where('code', 'boutique')->first()->id;
        $SmartNetworkTypeId = NetworkType::where('code', 'smart')->first()->id;

        $i = 0;
        foreach ($rows as $row) {
            $city = City::where('name', $row['city'])->first();
            if($city == null){
                $city = new City();
                $city->name = $row['city'];
                $city->delegation = $row['city'];
                $city->governorate = $row['city'];
                $city->zone = $row['city'];
                $city->save();
            }
            $i = $i + 1;
            $code = sprintf("B%04d", $i);
            $network = new Network();
            $network->code= $code;
            $network->name = $row['boutique'];
            $network->responsible = $row['responsable'];
            $network->address= '-';
            $network->phone= $row['tel'];
            $network->phone2= '';
            $network->land_line= '';
            $network->postal_code= '';
            if($network->name == 'Marsa')
                $network->type_id= $SmartNetworkTypeId;
            else
                $network->type_id= $BoutiqueNetworkTypeId;
            $network->city_id= $city->id;

            $network->save();
        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}