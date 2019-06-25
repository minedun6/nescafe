<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\City;
use  App\Models\PDV;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class PdvSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('pdvs')->truncate();

        //Seed pour les boutiques
        $results = Excel::selectSheetsByIndex(0)->load('storage/pdvs.xls', function($reader) {})->get();
        $rows = $results->toArray();

        $PdvcNetworkTypeId = NetworkType::where('code', 'pdvc')->first()->id;
        $PdvlNetworkTypeId = NetworkType::where('code', 'pdvl')->first()->id;
        $PdvgNetworkTypeId = NetworkType::where('code', 'pdvg')->first()->id;

        foreach ($rows as $row) {
            $city = City::where('name', $row['ville'])->where('governorate', trim($row['gouvernorat']))->first();
            if($city == null){
                $city = new City();
                $city->name = $row['ville'];
                $city->delegation = $row['deliguation'];
                $city->governorate = $row['gouvernorat'];
                //$city->zone = $row['gouvernorat'];
                $city->save();
            }

            $network = new Network();
            $network->code= $row['code'] != null ? $row['code']: '-';
            $network->name = $row['nom_pdv'] != null ? $row['nom_pdv']: '-';
            $network->responsible = $row['proprietaire'] != null ? $row['proprietaire']: '-';
            $network->address= $row['adresse'] != null ? $row['adresse']: '-';
            $network->phone= $row['mobile'] != null ? $row['mobile']: '-';
            $network->phone2= $row['mobile_2'] != null ? $row['mobile_2']: '-';
            $network->land_line= $row['fixe'] != null ? $row['fixe']: '-';
            $network->postal_code= $row['code_postal'] != null ? $row['code_postal']: '-';
            if($row['pdv_categorie'] == null){
                $network->type_id= $PdvcNetworkTypeId;
            }
            else if($row['pdv_categorie'] == 'Epicerie'){
                $network->type_id= $PdvcNetworkTypeId;
            }
            else if($row['pdv_categorie'] == 'Superette'){
                $network->type_id= $PdvlNetworkTypeId;
            }
            $network->city_id= $city->id;
            $network->save();

            $pdv = new PDV();
            $pdv->sector = $row['secteur'] != null ? $row['secteur']: '-';
            $pdv->cds = $row['cds'] != null ? $row['cds']: '-';
            $pdv->category	= $row['pdv_categorie'] != null ? strtolower($row['pdv_categorie']): 'Epicerie';
            $pdv->network_id = $network->id;

            $pdv->save();

        }

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}