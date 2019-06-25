<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\PhotoCategory;
use App\Models\NetworkType;

/**
 * Class UserRoleSeeder
 */
class PhotoCatSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('photo_categories')->truncate();

        $boutique_id = NetworkType::where('code', 'boutique')->first()->id;
        $franchise_id = NetworkType::where('code', 'franchise')->first()->id;
        $pdvc_id = NetworkType::where('code', 'pdvc')->first()->id;
        $pdvl_id = NetworkType::where('code', 'pdvl')->first()->id;
        $smart_id = NetworkType::where('code', 'smart')->first()->id;

        // Branding boutique
        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB001';
        $photoCat->value = 'Vitrine 1';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB002';
        $photoCat->value = 'Vitrine 2';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB003';
        $photoCat->value = 'Vitrine 3';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB004';
        $photoCat->value = 'Vitrine 4';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB005';
        $photoCat->value = 'Curseur PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB006';
        $photoCat->value = 'Affiche curseur iphone';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB007';
        $photoCat->value = 'Pop out univers fun';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB008';
        $photoCat->value = 'Pop out univers famille';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB009';
        $photoCat->value = 'Pop out univers travail';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB010';
        $photoCat->value = 'Pop out univers tech';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BB011';
        $photoCat->value = 'Autres PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        // Branding smart
        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS001';
        $photoCat->value = 'Vitrine 1';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS002';
        $photoCat->value = 'Vitrine 2';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS003';
        $photoCat->value = 'Vitrine 3';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS004';
        $photoCat->value = 'Vitrine 4';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS005';
        $photoCat->value = 'Curseur PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS006';
        $photoCat->value = 'Affiche curseur iphone';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS007';
        $photoCat->value = 'Pop out univers fun';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS008';
        $photoCat->value = 'Pop out univers famille';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS009';
        $photoCat->value = 'Pop out univers travail';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS010';
        $photoCat->value = 'Pop out univers tech';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BS011';
        $photoCat->value = 'Autres PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();

        // Branding franchise
        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF001';
        $photoCat->value = 'Vitrine 1';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF002';
        $photoCat->value = 'Vitrine 2';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF003';
        $photoCat->value = 'Vitrine 3';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF004';
        $photoCat->value = 'Vitrine 4';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF005';
        $photoCat->value = 'Affiche curseur iphone';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF006';
        $photoCat->value = 'Pop out univers fun';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF007';
        $photoCat->value = 'Pop out univers famille';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF008';
        $photoCat->value = 'Pop out univers travail';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF009';
        $photoCat->value = 'Pop out univers tech';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF010';
        $photoCat->value = 'Stop trottoires';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF011';
        $photoCat->value = 'X-Banner';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BF012';
        $photoCat->value = 'Autres PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        // Branding pdvl
        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL001';
        $photoCat->value = 'Vitrine';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL002';
        $photoCat->value = 'Pop out linéaire';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL003';
        $photoCat->value = 'Affiche A4';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL004';
        $photoCat->value = 'Cadre clic';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL005';
        $photoCat->value = 'Stop trottoires';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL006';
        $photoCat->value = 'X-Banner';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPL007';
        $photoCat->value = 'Autres PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        // Branding pdvc
        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPC001';
        $photoCat->value = 'Affiche A4';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPC002';
        $photoCat->value = 'Cadre clic';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'BPC003';
        $photoCat->value = 'Autres PLV';
        $photoCat->visit_type = 'branding';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        // Display boutique
        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB001';
        $photoCat->value = 'Univers fun';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB002';
        $photoCat->value = 'Univers famille';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB003';
        $photoCat->value = 'Univers travail';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB004';
        $photoCat->value = 'Linéaire tech';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB005';
        $photoCat->value = 'Libre service';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB006';
        $photoCat->value = 'Curseur iphone';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        // Display franchise
        $photoCat = new PhotoCategory();
        $photoCat->code = 'DF001';
        $photoCat->value = 'Univers fun';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DF002';
        $photoCat->value = 'Univers famille';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DF003';
        $photoCat->value = 'Univers travail';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DB004';
        $photoCat->value = 'Linéaire tech';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DF005';
        $photoCat->value = 'Libre service';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DF006';
        $photoCat->value = 'Curseur iphone';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        // Display pdvl
        $photoCat = new PhotoCategory();
        $photoCat->code = 'DPL001';
        $photoCat->value = 'Univers famille';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DPL002';
        $photoCat->value = 'Univers fun';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        // Display pdvc
        $photoCat = new PhotoCategory();
        $photoCat->code = 'DPC001';
        $photoCat->value = 'Vitrine';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'DPC002';
        $photoCat->value = 'Vitrine caisse';
        $photoCat->visit_type = 'display';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        // Online
        $photoCat = new PhotoCategory();
        $photoCat->code = 'OB001';
        $photoCat->value = 'Online';
        $photoCat->visit_type = 'online';
        $photoCat->network_type_id = $boutique_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'OF001';
        $photoCat->value = 'Online';
        $photoCat->visit_type = 'online';
        $photoCat->network_type_id = $franchise_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'OPC001';
        $photoCat->value = 'Online';
        $photoCat->visit_type = 'online';
        $photoCat->network_type_id = $pdvc_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'OPL001';
        $photoCat->value = 'Online';
        $photoCat->visit_type = 'online';
        $photoCat->network_type_id = $pdvl_id;
        $photoCat->save();

        $photoCat = new PhotoCategory();
        $photoCat->code = 'OS001';
        $photoCat->value = 'Online';
        $photoCat->visit_type = 'online';
        $photoCat->network_type_id = $smart_id;
        $photoCat->save();


        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}