<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\CheckList;

/**
 * Class UserRoleSeeder
 */
class NetworkCLSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('check_lists')->truncate();

        $checklist = new CheckList();
        $checklist->code = 'CLB';
        $checklist->name = 'Checklist Boutique';
        $checklist->network_type_id = NetworkType::where('code', 'boutique')->first()->id;
        $checklist->save();

        $checklist = new CheckList();
        $checklist->code = 'CLF';
        $checklist->name = 'Checklist Franchise';
        $checklist->network_type_id = NetworkType::where('code', 'franchise')->first()->id;
        $checklist->save();

        $checklist = new CheckList();
        $checklist->code = 'CLPC';
        $checklist->name = 'Checklist Epicerie';
        $checklist->network_type_id = NetworkType::where('code', 'pdvc')->first()->id;
        $checklist->save();

        $checklist = new CheckList();
        $checklist->code = 'CLPL';
        $checklist->name = 'Checklist Superette';
        $checklist->network_type_id = NetworkType::where('code', 'pdvl')->first()->id;
        $checklist->save();

        $checklist = new CheckList();
        $checklist->code = 'CLPG';
        $checklist->name = 'Checklist PDV gold';
        $checklist->network_type_id = NetworkType::where('code', 'pdvg')->first()->id;
        $checklist->save();

        $checklist = new CheckList();
        $checklist->code = 'CLS';
        $checklist->name = 'Checklist Smart store';
        $checklist->network_type_id = NetworkType::where('code', 'smart')->first()->id;
        $checklist->save();


        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}