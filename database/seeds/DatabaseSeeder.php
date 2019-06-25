<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call(AccessTableSeeder::class);

        //Networks
        $this->call(NetworkTypeSeeder::class);
        /*$this->call(NetworkSeeder::class);
        $this->call(FranchiseSeeder::class);*/
        //$this->call(PdvSeeder::class);

        //Checklists
        //$this->call(TaskCatSeeder::class);
        //$this->call(TaskSubCatSeeder::class);
        $this->call(NetworkCLSeeder::class);
        //$this->call(TaskSeeder::class);

        //Plannings
        /*$this->call(MedAmine0404Seeder::class);
        $this->call(MedAmineBalti0404Seeder::class);
        $this->call(HakimBrahim0404Seeder::class);
        $this->call(Nabil0404Seeder::class);
        $this->call(Hayet0404Seeder::class);
        $this->call(Sami0404Seeder::class);
        $this->call(Dimassi0404Seeder::class);
        $this->call(Nassim0404Seeder::class);
        $this->call(Abdrahman0404Seeder::class);
        $this->call(Mongi0404Seeder::class);
        $this->call(Ramzi0404Seeder::class);


        $this->call(PhotoCatSeeder::class);

        //Plannings 1404
        $this->call(Abdrahman1404Seeder::class);
        $this->call(Dimassi1404Seeder::class);
        $this->call(HakimBrahim1404Seeder::class);
        $this->call(Hayet1404Seeder::class);
        $this->call(MedAmine1404Seeder::class);
        $this->call(MedAmineBalti1404Seeder::class);
        $this->call(Mongi1404Seeder::class);
        $this->call(Nabil1404Seeder::class);
        $this->call(Nassim1404Seeder::class);
        $this->call(Ramzi1404Seeder::class);
        $this->call(Sami1404Seeder::class);

        //Planning 1804
        $this->call(Sami1804Seeder::class);
        $this->call(Dimassi1804Seeder::class);
        $this->call(Abdrahman1804Seeder::class);
        $this->call(HakimBrahim1804Seeder::class);
        $this->call(Hayet1804Seeder::class);
        $this->call(MedAmine1804Seeder::class);
        $this->call(MedAmineBalti1804Seeder::class);
        $this->call(Mongi1804Seeder::class);
        $this->call(Nabil1804Seeder::class);
        $this->call(Nassim1804Seeder::class);
        $this->call(Ramzi1804Seeder::class);

        //Planning 2504
        /*
        $this->call(Sami2504Seeder::class);
        $this->call(Dimassi2504Seeder::class);
        $this->call(Abdrahman2504Seeder::class);
        $this->call(HakimBrahim2504Seeder::class);
        $this->call(Hayet2504Seeder::class);
        $this->call(MedAmine2504Seeder::class);
        $this->call(MedAmineBalti2504Seeder::class);
        $this->call(Mongi2504Seeder::class);
        $this->call(Nabil2504Seeder::class);
        $this->call(Nassim2504Seeder::class);
        $this->call(Ramzi2504Seeder::class);*/


        //$this->call(FichesSeeder::class);

        //Planning 0706
        //*$this->call(NewNetworksSeeder::class);
        /*
                $this->call(Sami0706Seeder::class);
                $this->call(Dimassi0706Seeder::class);
                $this->call(Abdrahman0706Seeder::class);
                $this->call(HakimBrahim0706Seeder::class);
                $this->call(Hayet0706Seeder::class);
                $this->call(MedAmine0706Seeder::class);
                $this->call(MedAmineBalti0706Seeder::class);
                $this->call(Mongi0706Seeder::class);
                $this->call(Nabil0706Seeder::class);
                $this->call(Nassim0706Seeder::class);
                $this->call(Ramzi0706Seeder::class);*/

        /*$this->call(SamiSeeder::class);
        $this->call(DimassiSeeder::class);
        $this->call(AbdrahmanSeeder::class);
        $this->call(HakimBrahimSeeder::class);
        $this->call(HayetSeeder::class);
        $this->call(MedAmineSeeder::class);
        $this->call(MedAmineBaltiSeeder::class);
        $this->call(MongiSeeder::class);
        $this->call(NabilSeeder::class);
        $this->call(NassimSeeder::class);
        $this->call(RamziSeeder::class);*/

        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }


        Model::reguard();
    }
}
