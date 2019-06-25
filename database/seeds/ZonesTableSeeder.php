<?php

use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\Access\User\User;
use App\Models\City;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zone = new Zone();
        $zone->value = 'Monastir';
        $zone->code = 'monastir';
        $zone->save();
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/


        /*$zone = new Zone();
        $zone->value = 'Centre ville/Banlieue Nord';
        $zone->code = 'centre_ville-banlieu_nord';
        $zone->save();
        $user = User::where('email', 'amine.balti@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Sousse/Kairouan';
        $zone->code = 'sousse-kairouan';
        $zone->save();
        $user = User::where('email', 'amine.bacouche@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Nabeul';
        $zone->code = 'nabeul';
        $zone->save();
        $user = User::where('email', 'mohamed.dimassi@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Bizerte/Ariana';
        $zone->code = 'bizerte-ariana';
        $zone->save();
        $user = User::where('email', 'mongi.afouri@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Sfax';
        $zone->code = 'sfax';
        $zone->save();
        $user = User::where('email', 'nassim.baklouti@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Sud Ouest';
        $zone->code = 'sud_ouest';
        $zone->save();
        $user = User::where('email', 'nabil.chebbi@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Manouba/Tunis';
        $zone->code = 'manouba-tunis';
        $zone->save();
        $user = User::where('email', 'ramzi.khiari@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Nord Ouest';
        $zone->code = 'nord_ouest';
        $zone->save();
        $user = User::where('email', 'sami.messai@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Ben Arous/Zaghouan';
        $zone->code = 'ben_arous-zaghouan';
        $zone->save();
        $user = User::where('email', 'abderahmen.neyeb@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

        /*$zone = new Zone();
        $zone->value = 'Sud Est';
        $zone->code = 'sud_est';
        $zone->save();
        $user = User::where('email', 'abdelhakim.brahim@mit-tunisia.tn')->first();
        $user->zone_id = $zone->id;
        $user->save();*/
        /*$cities = City::join('networks', 'cities.id', '=', 'networks.city_id')
            ->join('visits', 'networks.id', '=', 'visits.network_id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->where('visits.user_id', $user->id)
            ->groupBy('cities.id')
            ->distinct()
            ->select('cities.*')
            ->get();
        foreach ($cities as $city) {
            $city->zone_id = $zone->id;
            $city->save();
        }*/

    }
}
