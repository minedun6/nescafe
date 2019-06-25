<?php

namespace App\Jobs;

use App\Exceptions\Backend\InvalidNetworkException;
use App\Jobs\Job;
use App\Models\Access\User\User;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use  App\Models\Visit;
use App\Models\CheckList;
use  App\Models\Network;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class GeneratePlanning extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user_id;
    protected $date_debut;
    protected $date_fin;
    protected $first_week;
    protected $path;

    protected $week1 = ['outlet' => 'outlet', 'delegation' => 'delegation', 'gouvernorat' => 'gouvernorat', 'type' => 'type'];
    protected $week2 = ['outlet' => 'outlet2', 'delegation' => 'delegation2', 'gouvernorat' => 'gouvernorat2', 'type' => 'type2'];


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct( $user_id, $path, $date_debut, $date_fin, $first_week)
    {
        $this->user_id = $user_id;
        $this->path = $path;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->first_week = $first_week;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        $state = true;
        if (env('DB_CONNECTION') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $results = Excel::selectSheetsByIndex(0)->load($this->path, function($reader) {})->get();
        $rows = $results->toArray();

        $date_debut = $this->date_debut;

        if($date_debut->dayOfWeek == 6) {
            $date_debut->addDay(2);
        } else if ($date_debut->dayOfWeek == 7) {
            $date_debut->addDay(1);
        }

        $date_en_cours = $date_debut->copy();
        $date_fin = $this->date_fin;

        $first_week = $this->first_week;
        $first_day = $date_debut->dayOfWeek - 1;
        $day_en_cours = $first_day;

        $week = $first_week == 1 ? $this->week1: $this->week2;
        $i = 0;
        while ($i< count($rows) && $rows[$i]['w1'] < $day_en_cours) {
            $i++;
        }
        try {

        for ($j = $i; $j < count($rows); $j++){
            if ($j != $i && $rows[$j]['w1'] != $rows[$j-1]['w1']){
                $day_en_cours++;
                $date_en_cours->addDay();
            }
            if ($rows[$j][$week['outlet']] != '' && $date_en_cours <= $date_fin) {
                $this->insertVisit($rows[$j], $date_en_cours, $week);
            }

        }
        $week = $week == $this->week1 ? $this->week2: $this->week1;
        $day_en_cours = 0;
        $date_en_cours->addDay(3);

        $i = 0;
        while ($date_en_cours <= $date_fin) {
            echo ($rows[$i][$week['outlet']] . '.');
            if ($rows[$i][$week['outlet']] != '') {
                echo ('('. $i . ')');
                $this->insertVisit($rows[$i], $date_en_cours, $week);
            }
            $i++;
            if ($i >= count($rows)){
                $i=0;
                echo 5;
                $week = $week == $this->week1 ? $this->week2: $this->week1;
                echo 6;
                $day_en_cours = 0;
                echo 7;
                $date_en_cours->addDay(3);
                echo 8;
            }

            if ($i!= 0 && $rows[$i]['w1'] != $rows[$i-1]['w1']){
                $day_en_cours++;
                $date_en_cours->addDay(1);
            }
        }

            if (env('DB_CONNECTION') == 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            }

            DB::commit();

        } catch (InvalidNetworkException $exception) {
            $user_name = User::find($this->user_id)->name;
            $attach = ['network_name' => $exception->networkName(), 'user' => $user_name,
                'date_debut' => $date_debut->format('d/m/Y'), 'date_fin' => $date_fin->format('d/m/Y'),
                'network_del' => $exception->networkDel(),'network_gouv' => $exception->networkGouv(),
                'network_type' => $exception->networkType()];
            Mail::send('frontend.emails.invalidNetwork', $attach, function ($message) use ($user_name) {
                $message->to('ghassen@peaksource.tn', 'Ghassen')->subject("Erreur lors de la génération de planning de " . $user_name);
            });
            DB::rollBack();
        }

    }

    public function insertVisit($row, $date, $week) {
        $day = $date->copy();
        $visit = new Visit();
        $visit->visit_date = $day;
        $networks = Network::where('name', $row[$week['outlet']])->get();
        if ($networks->first() == null){
            echo "network !!!! " . $row[$week['outlet']];
            $exception = new InvalidNetworkException;
            $exception->setNetworkName($row[$week['outlet']]);
            $exception->setNetworkDel($row[$week['delegation']]);
            $exception->setNetworkGouv($row[$week['gouvernorat']]);
            $exception->setNetworkType($row[$week['type']]);
            throw $exception;
        }
        $network1 = null; $network2 = null; $network3 = null; $network = null;
        foreach ($networks as $n) {
            if (strtolower(trim($n->city->governorate)) == strtolower(trim($row[$week['gouvernorat']]))
                && strtolower(trim($n->type->code)) == strtolower(trim($row[$week['type']]))
                && strtolower(trim($n->city->delegation)) == strtolower(trim($row[$week['delegation']]))
            ) {
                $network1 = $n;
                break;
            } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row[$week['gouvernorat']]))
                && strtolower(trim($n->type->code)) == strtolower(trim($row[$week['type']]))
            ) {
                $network2 = $n;
            } else if (strtolower(trim($n->city->governorate)) == strtolower(trim($row[$week['gouvernorat']]))) {
                $network3 = $n;
            }
        }
        if ($network1 != null) {
            $network = $network1;
        } else if ($network2 != null) {
            $network = $network2;
        } else if ($network3 != null) {
            $network = $network3;
        } else {
            $network = Network::where('name', $row[$week['outlet']])->first();
        }

        $visit->network_id = $network->id;
        $visit->check_list_id = CheckList::where('network_type_id', $network->type_id)->first()->id;
        $visit->user_id = $this->user_id;

        $visit->type = 'daily';
        $visit->save();
    }
}
