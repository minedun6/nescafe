<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\Network;
use  App\Models\NetworkType;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRoleSeeder
 */
class NetworkTypeSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('network_types')->truncate();

        $networkType = new NetworkType();
        $networkType->code = 'boutique';
        $networkType->value = 'Boutique';
        $networkType->save();

        $networkType = new NetworkType();
        $networkType->code = 'franchise';
        $networkType->value = 'Franchise';
        $networkType->save();

        $networkType = new NetworkType();
        $networkType->code = 'pdvc';
        $networkType->value = 'Epicerie';
        $networkType->save();

        $networkType = new NetworkType();
        $networkType->code = 'pdvl';
        $networkType->value = 'Superette';
        $networkType->save();

        $networkType = new NetworkType();
        $networkType->code = 'pdvg';
        $networkType->value = 'PDV Gold';
        $networkType->save();

        $networkType = new NetworkType();
        $networkType->code = 'smart';
        $networkType->value = 'Smart Store';
        $networkType->save();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}