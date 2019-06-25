<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

/**
 * Class UserRoleSeeder
 */
class FichesSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('fiches_techniques')->truncate();
        DB::beginTransaction();
        //Seed pour les boutiques
        $folders = File::directories(public_path('files/fiches'));
        foreach($folders as $folder) {
            $folderName = File::name($folder);
            $network_type = NetworkType::where('code', $folderName)->first();
            $files = File::files($folder);
            foreach ($files as $file) {
                // Create fiche without category and subcategory
                $filename = File::name($file);
                $filename_extension = File::extension($file);
                $fiche = new \App\Models\FicheTechnique();
                $fiche->nom = $filename;
                $fiche->path = 'files/fiches/'. $folderName . '/' . $filename . '.' . $filename_extension;
                $fiche->cible = starts_with($folderName, 'pdv') ? 'VI' : 'VD';
                $fiche->category = '-';
                $fiche->subcategory = '-';
                $fiche->network_type_id = $network_type->id;
                $fiche->save();
            }
            $subFolders = File::directories($folder);
            foreach($subFolders as $subFolder) {
                $subFolderName = File::name($subFolder);
                $subFiles = File::files($subFolder);
                foreach ($subFiles as $subFile) {
                    // Create fiche with category and  no subcategory
                    $subFilename = File::name($subFile);
                    $subFilename_extension = File::extension($subFile);
                    $fiche = new \App\Models\FicheTechnique();
                    $fiche->nom = $subFilename;
                    $fiche->path = 'files/fiches/'. $folderName . '/' . $subFolderName . '/' . $subFilename . '.' . $subFilename_extension;
                    $fiche->cible = starts_with($folderName, 'pdv') ? 'VI' : 'VD';
                    $fiche->category = $subFolderName;
                    $fiche->subcategory = '-';
                    $fiche->network_type_id = $network_type->id;
                    $fiche->save();
                }
                $subSubFolders = File::directories($subFolder);
                foreach($subSubFolders as $subSubFolder) {
                    $subSubFolderName = File::name($subSubFolder);
                    $subSubFiles = File::files($subSubFolder);
                    foreach ($subSubFiles as $subSubFile) {
                        // Create fiche with category and subcategory
                        $subSubFilename = File::name($subSubFile);
                        $subSubFilename_extension = File::extension($subSubFile);
                        $fiche = new \App\Models\FicheTechnique();
                        $fiche->nom = $subSubFilename;
                        $fiche->path = 'files/fiches/'. $folderName . '/' . $subFolderName . '/' . $subSubFolderName . '/' . $subSubFilename . '.' . $subSubFilename_extension;
                        $fiche->cible = starts_with($folderName, 'pdv') ? 'VI' : 'VD';
                        $fiche->category = $subFolderName;
                        $fiche->subcategory = $subSubFolderName;
                        $fiche->network_type_id = $network_type->id;
                        $fiche->save();
                    }
                }
            }
        }

        DB::commit();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}