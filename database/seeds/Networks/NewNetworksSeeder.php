<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use  App\Models\NetworkType;
use  App\Models\Network;
use  App\Models\City;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PDV;

/**
 * Class UserRoleSeeder
 */
class NewNetworksSeeder extends Seeder
{
    public function run()
    {
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }


        $BoutiqueNetworkTypeId = NetworkType::where('code', 'boutique')->first()->id;
        $SmartNetworkTypeId = NetworkType::where('code', 'smart')->first()->id;
        $PdvcNetworkTypeId = NetworkType::where('code', 'pdvc')->first()->id;
        $PdvlNetworkTypeId = NetworkType::where('code', 'pdvl')->first()->id;
        $PdvgNetworkTypeId = NetworkType::where('code', 'pdvg')->first()->id;


        //B1
        /*$city = City::where('name', 'Menzel bouzelfa')->where('governorate', 'NABEUL')->first();
        if($city == null){
                $city = new City();
                $city->name = 'Menzel bouzelfa';
                $city->delegation = 'Menzel bouzelfa';
                $city->governorate = 'NABEUL';
                $city->zone = 'NABEUL';
                $city->save();
        }

        $network = new Network();
        $network->code= 'NAB0040';
        $network->name = 'Hambourg gsm';
        $network->responsible = 'IMED BEN SALAH';
        $network->address= '56 rue Habib Bourguiba';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '8010';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B2
        $network = Network::where('name', 'GOLDEN PHONE')->where('address', 'AV FARHAT HACHED')->first();
        $network->name = 'GOLDEN PHONE 2';
        $network->save();

        //B3
        $network = Network::where('name', 'GOLDEN PHONE')->where('address', 'RUE KORBA')->first();
        $network->name = 'GOLDEN PHONE 1';
        $network->save();

        //B4
        $network = Network::where('name', 'GOLDEN PHONE')->where('address', 'AV HABIB BOURGUIBA')->first();
        $network->name = 'GOLDEN PHONE 3';
        $network->save();

        //B5
        $city = City::where('name', 'HAMMAM SOUSSE')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'HAMMAM SOUSSE';
            $city->delegation = 'SOUSSE';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0150';
        $network->name = 'TIMOTECH TRADE';
        $network->responsible = 'KARIM TOUIL';
        $network->address= 'RUE MAAMOUN';
        $network->phone= 'karim.touil007@gmail.com';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '4000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B6
        $city = City::where('name', 'SOUSSE')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'SOUSSE';
            $city->delegation = 'SOUSSE VILLE';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0170';
        $network->name = 'STE AITECK';
        $network->responsible = 'IMED BERGUIGA';
        $network->address= 'BECHIR SFAR';
        $network->phone= 'karim.touil007@gmail.com';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '4000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();*/

        //B7
        $city = City::where('name', 'SAHLOUL')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'SAHLOUL';
            $city->delegation = 'SAHLOUL';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0167';
        $network->name = 'MAC DISTRIBUTION 2';
        $network->responsible = 'JENDOUBI KARIMA';
        $network->address= 'ARAFAT';
        $network->phone= 'macdistribution2015@gmail.com';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '4054';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B8
        $city = City::where('name', 'SOUSSE')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'SOUSSE';
            $city->delegation = 'SOUSSE VILLE';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0168';
        $network->name = 'MOBILE TECHNOLOGIE';
        $network->responsible = 'KARIM NASRI';
        $network->address= 'DR MOREAU';
        $network->phone= 'mirakfou@live.fr';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '4000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B9
        $city = City::where('name', 'CITE ERRIADH')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE ERRIADH';
            $city->delegation = 'CITE ERRIADH';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0171';
        $network->name = 'UNIVERS INFORMATIQUE';
        $network->responsible = 'FOUED TOUMI';
        $network->address= '1 RUE IBN CHARAF';
        $network->phone= '56180991';
        $network->phone2= 'chokri.2003@gmail.com';
        $network->land_line= '-';
        $network->postal_code= '4023';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B10
        $city = City::where('name', 'CITE ERRIADH')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE ERRIADH';
            $city->delegation = 'CITE ERRIADH';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0173';
        $network->name = 'Melek Com';
        $network->responsible = 'SAIDA SASSI';
        $network->address= '1 RUE GHAZALI';
        $network->phone= '51122825';
        $network->phone2= 'melektelecomservice@gmail.com';
        $network->land_line= '-';
        $network->postal_code= '4000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'Makram Azzouz';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B11
        $city = City::where('name', 'EL ALA')->where('governorate', 'KAIROUAN')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL ALA';
            $city->delegation = 'EL ALA';
            $city->governorate = 'KAIROUAN';
            $city->zone = 'KAIROUAN';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0001';
        $network->name = 'Studio Sindibad';
        $network->responsible = '-';
        $network->address= 'EL ALA';
        $network->phone= '51122825';
        $network->phone2= 'melektelecomservice@gmail.com';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B12
        $city = City::where('name', 'HAFFOUZ')->where('governorate', 'KAIROUAN')->first();
        if($city == null){
            $city = new City();
            $city->name = 'HAFFOUZ';
            $city->delegation = 'HAFFOUZ';
            $city->governorate = 'KAIROUAN';
            $city->zone = 'KAIROUAN';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0002';
        $network->name = 'MAHROUNI';
        $network->responsible = '-';
        $network->address= 'HAFFOUZ';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B13
        $city = City::where('name', 'ROUTE HAFFOUZ')->where('governorate', 'KAIROUAN')->first();
        if($city == null){
            $city = new City();
            $city->name = 'ROUTE HAFFOUZ';
            $city->delegation = 'ROUTE HAFFOUZ';
            $city->governorate = 'KAIROUAN';
            $city->zone = 'KAIROUAN';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0003';
        $network->name = 'SBI';
        $network->responsible = '-';
        $network->address= 'ROUTE HAFFOUZ';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B14
        $city = City::where('name', 'CHRARDA')->where('governorate', 'KAIROUAN')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CHRARDA';
            $city->delegation = 'CHRARDA';
            $city->governorate = 'KAIROUAN';
            $city->zone = 'KAIROUAN';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0004';
        $network->name = 'BEN SALEM GSM';
        $network->responsible = '-';
        $network->address= 'CHRARDA';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B15
        $city = City::where('name', 'NASRALLAH')->where('governorate', 'KAIROUAN')->first();
        if($city == null){
            $city = new City();
            $city->name = 'NASRALLAH';
            $city->delegation = 'NASRALLAH';
            $city->governorate = 'KAIROUAN';
            $city->zone = 'KAIROUAN';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0005';
        $network->name = 'C INFO';
        $network->responsible = '-';
        $network->address= 'NASRALLAH';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B16
        $city = City::where('name', 'SAHLOUL')->where('governorate', 'SOUSSE')->first();
        if($city == null){
            $city = new City();
            $city->name = 'SAHLOUL';
            $city->delegation = 'SAHLOUL';
            $city->governorate = 'SOUSSE';
            $city->zone = 'SOUSSE';
            $city->save();
        }

        $network = new Network();
        $network->code= 'SOU0166';
        $network->name = 'GSM info';
        $network->responsible = 'GHRAIRI WISSEM';
        $network->address= 'Z4 SAHLOUL';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '4054';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOHAMED BOUKADIDA';
        $pdv->cds = 'HAYTHAM HAGGUI';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //fin Sousse

        //debut Tunis
        //B17
        $city = City::where('name', 'EL OMRANE SUPERIEUR')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL OMRANE SUPERIEUR';
            $city->delegation = 'EL OMRANE SUPERIEUR';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0265';
        $network->name = 'Loop info';
        $network->responsible = 'Mohamed CHLAGOU';
        $network->address= 'Centre Comemrcial El Omran Sup';
        $network->phone= '52188485';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1091';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B18
        $city = City::where('name', 'CITE 18 JANVIER')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE 18 JANVIER';
            $city->delegation = 'ETTADHAMEN';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'MAN0033';
        $network->name = 'WISSEM MEDIA';
        $network->responsible = 'MBARKI FATHI';
        $network->address= 'Av 7 Novembre n°87';
        $network->phone= '52776566';
        $network->phone2= '22022000';
        $network->land_line= '70664976';
        $network->postal_code= '2041';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B19
        $city = City::where('name', 'CITE 18 JANVIER')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE 18 JANVIER';
            $city->delegation = 'ETTADHAMEN';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'MAN0038';
        $network->name = 'WISSEM MEDIA';
        $network->responsible = 'MBARKI FATHI';
        $network->address= 'Av. ibn khaldoun cité tadhamen ';
        $network->phone= '52776566';
        $network->phone2= '26397574';
        $network->land_line= '70664976';
        $network->postal_code= '2041';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B20
        $city = City::where('name', 'CITE ETTADHAMEN')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE ETTADHAMEN';
            $city->delegation = 'ETTADHAMEN';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'MAN0081';
        $network->name = 'Wissem Media 2';
        $network->responsible = 'Sihem SIDOUMOU';
        $network->address= 'Cité Ettadhaman';
        $network->phone= '55442248';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2041';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B21
        $city = City::where('name', 'EZZAHROUNI')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EZZAHROUNI';
            $city->delegation = 'EL HRAIRIA';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0038';
        $network->name = 'HOUAS Telecom';
        $network->responsible = 'OUNAISSA WASSILA';
        $network->address= '34 Rue 4366 Cité Warda Ezzahrouni';
        $network->phone= '55792332';
        $network->phone2= '99841752';
        $network->land_line= '-';
        $network->postal_code= '2051';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'ANTAR MHAMDI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B22
        $city = City::where('name', 'EZZAHROUNI')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EZZAHROUNI';
            $city->delegation = 'EL HRAIRIA';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0117';
        $network->name = 'Palmier GSM';
        $network->responsible = 'Jawher Horchani';
        $network->address= '39 Av Ennakhil Ezzahrouni';
        $network->phone= '55322220';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2051';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'ANTAR MHAMDI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B23
        $city = City::where('name', 'CITE IBN KHALDOUN')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE IBN KHALDOUN';
            $city->delegation = 'EL OMRANE SUPERIEUR';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0215';
        $network->name = 'Télé Sat';
        $network->responsible = 'Jamel Boutara';
        $network->address= 'Rue 6900 N°80 Omrane Sup';
        $network->phone= '55530467';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2062';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B24
        $city = City::where('name', 'CITE ETTAHRIR SUP')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE ETTAHRIR SUP';
            $city->delegation = 'ETTAHRIR';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0250';
        $network->name = 'I SHOP';
        $network->responsible = 'Zouaoui Ghazi';
        $network->address= 'Cité Ettahrir Sup';
        $network->phone= '50803667';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2042';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B25
        $city = City::where('name', 'EL OMRANE SUPERIEUR')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL OMRANE SUPERIEUR';
            $city->delegation = 'EL OMRANE SUPERIEUR';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0093';
        $network->name = 'ULTRA SIM';
        $network->responsible = 'Rim Kraiem';
        $network->address= '51, Rue 6670 Omrane Sup';
        $network->phone= '55373813';
        $network->phone2= '24082810';
        $network->land_line= '-';
        $network->postal_code= '1091';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B26
        $city = City::where('name', 'CITE IBN KHALDOUN')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE IBN KHALDOUN';
            $city->delegation = 'EL OMRANE SUPERIEUR';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0116';
        $network->name = 'ULTRA SIM';
        $network->responsible = 'Rim Kraiem';
        $network->address= '21 Rue 6691 Ibn Khaldoun';
        $network->phone= '55373813';
        $network->phone2= '24082810';
        $network->land_line= '-';
        $network->postal_code= '1091';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B27
        $city = City::where('name', 'bardo')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'bardo';
            $city->delegation = 'bardo';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0258';
        $network->name = 'Lina Media';
        $network->responsible = 'Ben Ammar Sameh';
        $network->address= '71 avenue Bayrem Ettounsi';
        $network->phone= '55931585';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'ANTAR MHAMDI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B28
        $city = City::where('name', 'bardo')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'bardo';
            $city->delegation = 'bardo';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0258';
        $network->name = 'Lina Media';
        $network->responsible = 'Ben Ammar Sameh';
        $network->address= '71 avenue Bayrem Ettounsi';
        $network->phone= '55931585';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2000';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'ANTAR MHAMDI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B29
        $city = City::where('name', 'EL OMRANE')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL OMRANE';
            $city->delegation = 'EL OMRANE';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0132';
        $network->name = 'COMMUNICATION EL OMRANE';
        $network->responsible = 'Hatem Ben Dabous';
        $network->address= '23 Rue Larbi Kabadi 1005';
        $network->phone= '55165433';
        $network->phone2= '20083664';
        $network->land_line= '-';
        $network->postal_code= '1005';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HICHEM BEN REJEB';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //Fin Tunis

        //Debut JENDOUBA
        //B30
        $city = City::where('name', '-')->where('governorate', '-')->first();
        if($city == null){
            $city = new City();
            $city->name = '-';
            $city->delegation = '-';
            $city->governorate = '-';
            $city->zone = '-';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0006';
        $network->name = 'UNIVERS INFORMATIQUE THIBAR';
        $network->responsible = '-';
        $network->address= '-';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B31
        $city = City::where('name', '-')->where('governorate', '-')->first();
        if($city == null){
            $city = new City();
            $city->name = '-';
            $city->delegation = '-';
            $city->governorate = '-';
            $city->zone = '-';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0007';
        $network->name = 'TECH STORE';
        $network->responsible = '-';
        $network->address= '-';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B32
        $city = City::where('name', '-')->where('governorate', '-')->first();
        if($city == null){
            $city = new City();
            $city->name = '-';
            $city->delegation = '-';
            $city->governorate = '-';
            $city->zone = '-';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0008';
        $network->name = 'NEFZA 3G+';
        $network->responsible = '-';
        $network->address= '-';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B33
        $network = Network::where('name', 'QUEEN INFO')->first();
        $network->type_id= $PdvlNetworkTypeId;
        $network->save();

        $pdv = PDV::where('network_id', $network->id)->first();
        $pdv->category	= 'classique';
        $pdv->save();

        //B34
        $city = City::where('name', 'Borj Sedria')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'Borj Sedria';
            $city->delegation = 'Borj Sedria';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NAB0143';
        $network->name = 'Erriadh mobile';
        $network->responsible = 'Ali BEN NAJI';
        $network->address= 'rue IRAK';
        $network->phone= '55597968';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '8020';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B35
        $city = City::where('name', 'BIR ZENDALA')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BIR ZENDALA';
            $city->delegation = 'FOUCHANA';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0004';
        $network->name = 'ELECTRO CHAABANE GSM +';
        $network->responsible = 'Gamra Chaaben';
        $network->address= '9, Av 7 Novembre Naassen';
        $network->phone= '55585538';
        $network->phone2= '98585538';
        $network->land_line= '79307566';
        $network->postal_code= '1135';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B36
        $city = City::where('name', 'BEN AROUS')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BEN AROUS';
            $city->delegation = 'BEN AROUS';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0022';
        $network->name = 'PC Phone';
        $network->responsible = 'Zidi Karim';
        $network->address= '10 rue Habib Thameur - Ben Arous';
        $network->phone= '55323399';
        $network->phone2= '22323399';
        $network->land_line= '-';
        $network->postal_code= '2013';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B37
        $city = City::where('name', 'MORNAG')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MORNAG';
            $city->delegation = 'MORNAG';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0024';
        $network->name = 'Phone.Com';
        $network->responsible = 'Ayari Naima';
        $network->address= '8 avenue 7 novembre - Mornag';
        $network->phone= '55410300';
        $network->phone2= '21319000';
        $network->land_line= '-';
        $network->postal_code= '2090';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B38
        $city = City::where('name', 'FOUCHANA')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'FOUCHANA';
            $city->delegation = 'FOUCHANA';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0029';
        $network->name = 'Rayen GSM';
        $network->responsible = 'Jlassi Warda';
        $network->address= 'AV 7 Novembre  à côté Ettijari Bank';
        $network->phone= '55420030';
        $network->phone2= '22450450';
        $network->land_line= '-';
        $network->postal_code= '2082';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B39
        $city = City::where('name', 'MEGRINE')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MEGRINE';
            $city->delegation = 'MEGRINE';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0048';
        $network->name = 'AB Informatique';
        $network->responsible = 'Bassem Aloui';
        $network->address= '4 Rue Ibn Aljazzar';
        $network->phone= '55038360';
        $network->phone2= '20942132';
        $network->land_line= '71295103';
        $network->postal_code= '2033';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B40
        $city = City::where('name', 'BEN AROUS')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BEN AROUS';
            $city->delegation = 'BEN AROUS';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0060';
        $network->name = 'Pentium+';
        $network->responsible = 'Kaouech Hanen';
        $network->address= '11 Av de la république Ben Arous';
        $network->phone= '55977870';
        $network->phone2= '23189657';
        $network->land_line= '71383066';
        $network->postal_code= '2013';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B41
        $city = City::where('name', 'MEGRINE')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MEGRINE';
            $city->delegation = 'MEGRINE';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0066';
        $network->name = 'MEGRINE PHONE';
        $network->responsible = 'BEN DHAFER MOUNA';
        $network->address= '11 EV HABIB BOURGUIBA';
        $network->phone= '55180220';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2033';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B42
        $city = City::where('name', 'BEN AROUS')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BEN AROUS';
            $city->delegation = 'BEN AROUS';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0067';
        $network->name = 'OMEGA GSM';
        $network->responsible = 'Taher Lamjed';
        $network->address= 'Ali Bech Hamba';
        $network->phone= '52577488';
        $network->phone2= '22377844';
        $network->land_line= '-';
        $network->postal_code= '2013';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B43
        $city = City::where('name', 'MORNAG')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MORNAG';
            $city->delegation = 'MORNAG';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0071';
        $network->name = 'PHONE.COM2';
        $network->responsible = 'Naima Ayari';
        $network->address= 'Av Farhat Hached Mornag';
        $network->phone= '54168840';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2090';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B44
        $city = City::where('name', 'FOUCHANA')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'FOUCHANA';
            $city->delegation = 'FOUCHANA';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0074';
        $network->name = 'ELECTRO NOZHA';
        $network->responsible = 'BOUSSELMI SABER';
        $network->address= 'Cité Amal Fouchana';
        $network->phone= '53005269';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2082';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B45
        $city = City::where('name', 'MEGRINE CHAKER')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MEGRINE CHAKER';
            $city->delegation = 'MEGRINE';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0095';
        $network->name = 'EXTASY';
        $network->responsible = 'HAMZA HAMDI';
        $network->address= '15 AVE AHMED TLILI';
        $network->phone= '53551190';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2024';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B46
        $city = City::where('name', 'MOHAMADIA')->where('governorate', 'BEN AROUS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MOHAMADIA';
            $city->delegation = 'MOHAMADIA';
            $city->governorate = 'BEN AROUS';
            $city->zone = 'BEN AROUS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'BEN0099';
        $network->name = 'GSM ARENA';
        $network->responsible = 'AYMEN MRAIDI';
        $network->address= 'avenue MAGASIN N°3 CENTRE COMMERCIAL ';
        $network->phone= '53115100';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1145';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'AMOR ABROUGUI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //Fin ben arous

        //Debut Ariana
        //B47
        $city = City::where('name', 'CITE 18 JANVIER')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE 18 JANVIER';
            $city->delegation = 'ETTADHAMEN';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'MAN0004';
        $network->name = 'Electro informatique bouzaiene';
        $network->responsible = 'BOUZAIEN SAID';
        $network->address= '73 bis Av. ibn khaldoun mnihla tadhamen';
        $network->phone= '55157174';
        $network->phone2= '22029900';
        $network->land_line= '70663913';
        $network->postal_code= '2041';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B48
        $city = City::where('name', 'CITE ALI BOURGUIBA')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'CITE ALI BOURGUIBA';
            $city->delegation = 'MNIHLA';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'MAN0013';
        $network->name = 'SDS';
        $network->responsible = 'DRINE RAOUF';
        $network->address= 'Route de Bizerte Km 4 Mnihla -Intilaka';
        $network->phone= '50020272';
        $network->phone2= '20316709/20541515';
        $network->land_line= '71654160';
        $network->postal_code= '2094';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //fin ariana

        //debut tunis
        //B49
        $city = City::where('name', 'EL MENZAH 4')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL MENZAH 4';
            $city->delegation = 'EL MENZAH';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0009';
        $network->name = 'SYSTEL';
        $network->responsible = '-';
        $network->address= '3 RUE Ibn Bassem';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1082';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B50
        $city = City::where('name', 'DAR FADHAL')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'DAR FADHAL';
            $city->delegation = 'SOKRA';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'ARI0031';
        $network->name = 'POINT COM';
        $network->responsible = 'GUERFEL INES';
        $network->address= '25 Résidece Elias Av de l Environnement 2036 N 25';
        $network->phone= '55863656';
        $network->phone2= '22781786';
        $network->land_line= '-';
        $network->postal_code= '2036';
        $network->type_id= $PdvlNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOURAD BEN TOUMINE';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'labelise';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B51
        $city = City::where('name', 'LA SOUKRA')->where('governorate', 'ARIANA')->first();
        if($city == null){
            $city = new City();
            $city->name = 'LA SOUKRA';
            $city->delegation = 'LA SOUKRA';
            $city->governorate = 'ARIANA';
            $city->zone = 'ARIANA';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0268';
        $network->name = 'MT PHONE';
        $network->responsible = 'Trabelsi Nabil';
        $network->address= 'Rue des Amandes cité ben brik ';
        $network->phone= '58015043';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '2036';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'MOURAD BEN TOUMINE';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B52
        $city = City::where('name', 'BERGE DU LAC')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BERGE DU LAC';
            $city->delegation = 'LA MARSA';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0266';
        $network->name = 'Cell Phone Store';
        $network->responsible = 'Hichem Ounis';
        $network->address= 'AV Habib Achour Les Berges du Lac';
        $network->phone= '58977446';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1053';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B53
        $city = City::where('name', 'BERGE DU LAC')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'BERGE DU LAC';
            $city->delegation = 'LA MARSA';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0277';
        $network->name = 'EVATEK TUNISIA MALL';
        $network->responsible = 'MOHSEN BEN AMOR';
        $network->address= 'TUNISIA MALL CENTRE COMMERCAIL Berges DU LAC 2';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1053';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //B54
        $city = City::where('name', 'EL MELLASSINE')->where('governorate', 'TUNIS')->first();
        if($city == null){
            $city = new City();
            $city->name = 'EL MELLASSINE';
            $city->delegation = 'ESSIJOUMI';
            $city->governorate = 'TUNIS';
            $city->zone = 'TUNIS';
            $city->save();
        }

        $network = new Network();
        $network->code= 'TUN0238';
        $network->name = 'ZIED COM';
        $network->responsible = 'TOUATI ZIED';
        $network->address= '07 rue 41647 cité Jalloul 2, 09 AVRIL Tunis 1007';
        $network->phone= '52270835';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '1007';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = 'HOSNI SBAOUELJI';
        $pdv->cds = 'RIADH HALLAB';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();

        //BB55
        $city = City::where('name', 'MONASTIR')->where('governorate', 'MONASTIR')->first();
        if($city == null){
            $city = new City();
            $city->name = 'MONASTIR';
            $city->delegation = 'MONASTIR';
            $city->governorate = 'MONASTIR';
            $city->zone = 'MONASTIR';
            $city->save();
        }
        $network = new Network();
        $network->code= 'SSMON';
        $network->name = 'SMART STORE Monastir';
        $network->responsible = '-';
        $network->address= '-';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $SmartNetworkTypeId;
        $network->city_id= $city->id;

        $network->save();

        //B56
        $city = City::where('name', 'SAHLINE')->where('governorate', 'MONASTIR')->first();
        if($city == null){
            $city = new City();
            $city->name = 'SAHLINE';
            $city->delegation = 'SAHLINE';
            $city->governorate = 'MONASTIR';
            $city->zone = 'MONASTIR';
            $city->save();
        }

        $network = new Network();
        $network->code= 'NEW0010';
        $network->name = 'Mobile Store';
        $network->responsible = '-';
        $network->address= '-';
        $network->phone= '-';
        $network->phone2= '-';
        $network->land_line= '-';
        $network->postal_code= '-';
        $network->type_id= $PdvcNetworkTypeId;
        $network->city_id= $city->id;
        $network->save();

        $pdv = new PDV();
        $pdv->sector = '-';
        $pdv->cds = '-';
        $pdv->category	= 'classique';
        $pdv->network_id = $network->id;
        $pdv->save();



        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}