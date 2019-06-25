@extends('frontend.layouts.master')
@section('second-title')
    | {{ $merch->name }}
@stop
@section('url-way')
    <li>
        <a href="#">Statistiques</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visites')}}">Merchandisers</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $merch->name }}</a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">{{ $merch->name }}</span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6"><b>Email :</b> {{ $merch->email }}  </div>
                        <br>
                        <div class="col-md-6"><b>Zone :</b> {{ $merch->zone ? $merch->zone->value : '' }} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ****************************************************************************************** -->

    <!-- END PAGE HEADER-->
    <style>
        .dataTables_info {
            display: none;
        }
    </style>
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-md-9">
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

                <div class="dashboard-stat grey-cararra">
                    <div class="visual">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup">{{ $total_visits }}</span>
                        </div>
                        <div class="desc"> Total des visites</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

                <div class="dashboard-stat blue">

                    <div class="visual">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                            <span data-counter="counterup">{{ $number_of_visits_this_month }}</span>
                        </div>
                        <div class="desc"> Visites (ce mois)</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

                <div class="dashboard-stat green-meadow">
                    <div class="visual">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                            <span data-counter="counterup">{{ $number_of_visits_last_month }}</span></div>
                        <div class="desc"> Visites (dernier mois)</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

                <div class="dashboard-stat purple">
                    <div class="visual">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                            <span data-counter="counterup">{{ $number_of_visits_last_week }}</span></div>
                        <div class="desc"> Visites (cette semaine)</div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="details">
                        <div class="number">

                            <span data-counter="counterup">{{ $number_of_visits_last_fifteen_days }}</span></div>
                        <div class="desc"> Visites (ces 15 jours)</div>

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">
                <div class="dashboard-stat red">
                    <div class="visual">

                        <i class="fa fa-warning"></i>

                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup">{{ $network_number_with_anomalies }}</span></div>

                        <div class="desc"> Réseaux avec anomalies</div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mt-element-ribbon bg-grey-steel" style="text-align: center;">

                    <div class="ribbon ribbon-color-danger uppercase ">Réseau avec le plus grand pourcentage d'anomalie
                    </div>
                    <div style="margin-top: 10px;">
                        @if(count($top_five_anomalies) > 0)
                            <?php $network = $top_five_anomalies[0]->network;  ?>
                            @if($network)
                                <p class="ribbon-content"><br>
                                    <?php $type = $network->type->code == 'pdvc' || $network->type->code == 'pdvl' ? 'pdv' : $network->type->code  ?>
                                    <b><a href="{{ url('/network/detail/'.$type.'/'.$network->id) }}">{{ $network->name }}</a>
                                    </b> <br>
                                    <i>{{ $network->type ? $network->type->value : '' }}</i>
                                    <br>
                                    <span style="font-size: 30px;font-weight: bold;color: red;">{{ $top_five_anomalies[0] ?$top_five_anomalies[0]->anomalies. ' %' : '' }}</span>
                                    <br>
                                    {{ $network->city ? $network->city->delegation : '' }}
                                    <br>
                                    {{ $network->city ? $network->city->governorate : '' }}
                                    <br>
                                    {!! $top_five_anomalies[0] ? '<a href="'.url('visits/daily/'.$top_five_anomalies[0]->id).'">' .\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $top_five_anomalies[0]->updated_at)->format('d-m-Y').'</a>' : '' !!}
                                </p>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Visites </span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn red btn-outline btn-circle btn-sm active">2 dernières semaines</label>
                            <label class="btn red btn-outline btn-circle btn-sm active"
                                   style="background-color: #88aef3;border-color: #88aef3;">2 semaines d'avant</label>
                        </div>
                    </div>

                </div>
                <div class="portlet-body">
                    <div id="site_statistics_loading">
                        <img src="<?php echo URL::asset('/frontend/assets/global/img/loading.gif')?>"
                             alt="loading"/>
                    </div>
                    <div id="site_statistics_content" class="display-none">
                        <div id="site_statistics" class="chart"></div>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

    <!-- Stats sur les visites -->
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Planification des Visites</span>
                        <span class="caption-helper"></span>
                    </div>
                    <div class="actions">
                        <div class="btn-group btn-group-devided" data-toggle="buttons">
                            <label class="btn red btn-outline btn-circle btn-sm active"
                                   style="background-color: #88aef3;border-color: #88aef3;">Visites planifiées</label>
                            <label class="btn red btn-outline btn-circle btn-sm active">Visites effectuées</label>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="visit_statistics_loading">
                        <img src="<?php echo URL::asset('/frontend/assets/global/img/loading.gif')?>" alt="loading"/>
                    </div>
                    <div id="visit_statistics_content" class="display-none">
                        <div id="visit_statistics" class="chart"></div>
                    </div>
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

            <div class="dashboard-stat grey-cararra">
                <div class="visual">
                    <i class="fa fa-user"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup">{{ $daily_percent }} %</span>
                    </div>
                    <div class="desc"> Cheklist</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

            <div class="dashboard-stat blue">

                <div class="visual">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="details">
                    <div class="number">

                        <span data-counter="counterup">{{ $branding_percent }} %</span>
                    </div>
                    <div class="desc">Visite Branding</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

            <div class="dashboard-stat green-meadow">
                <div class="visual">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="details">
                    <div class="number">

                        <span data-counter="counterup">{{ $display_percent }} %</span></div>
                    <div class="desc">Visite Display</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

            <div class="dashboard-stat purple">
                <div class="visual">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="details">
                    <div class="number">

                        <span data-counter="counterup">{{ $online_percent }} %</span></div>
                    <div class="desc">Visite Online</div>

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">

            <div class="dashboard-stat green">
                <div class="visual">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="details">
                    <div class="number">

                        <span data-counter="counterup">{{ $ilv_percent }} %</span></div>
                    <div class="desc"> Visite ILV</div>

                </div>
            </div>
        </div>

    </div>

    <div class="row" style="margin: 20px;">
        <h3 class="page-title"> TOP 5 des anomalies
            <small></small>
        </h3>
        <table class="table table-striped table-bordered table-hover" id="rapport_table1">
            <thead>
            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                <th style=" color: #F2784B; width: 10%;"> Date</th>
                <th style=" color: #F2784B; width: 10%;"> Reseau</th>
                <th style=" color: #F2784B; width: 8%; text-align: center; "> Type</th>
                <th style=" color: #F2784B; width: 10%; text-align: center;"> Délégation</th>
                <th style=" color: #F2784B; width: 8%; text-align: center;"> Gouvernorat</th>
                <th style=" color: #F2784B; width: 5%; text-align: center; valign:center;"> B.merch</th>
                <th style=" color: #F2784B; width: 5%; text-align: center; valign:center;"> Anomalie</th>
            </tr>
            </thead>
            <tbody>
            @foreach($top_five_anomalies as $visit)
                <tr>
                    <td>
                        <a href="{{ url('visits/daily/'.$visit->id) }}">{{ $visit->updated_at->format('d-m-Y') }}</a>
                    </td>
                    <td>
                        <?php
                        $type = $visit->network->type->code == 'pdvc' || $visit->network->type->code == 'pdvl' ? 'pdv' : $visit->network->type->code;
                        ?>
                        <a href="{{ url('network/detail/'.$type.'/'.$visit->network->id) }}">{{ $visit->network ? $visit->network->name : '' }}</a>
                    </td>
                    <td>{{ $visit->network ? ($visit->network->type ? $visit->network->type->value : '' ) : '' }}</td>
                    <td>{{ $visit->network ? ($visit->network->city ? $visit->network->city->delegation : '' ) : '' }}</td>
                    <td>{{ $visit->network ? ($visit->network->city ? $visit->network->city->governorate : '' ) : '' }}</td>
                    <td style="text-align:center;"><span
                                class="badge  badge-success">{{ $visit->bmerch.' %' }}</span>
                    </td>
                    <td style="text-align:center;"><span
                                class="badge  badge-danger">{{ $visit->anomalies.' %' }}</span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    <div class="row" style="margin: 20px;">
        <h3 class="page-title"> TOP 3 des anomalies
            <small>Par type réseaux</small>
        </h3>

        <div class="col-md-6 nnn">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Boutiques</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table2">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">
                                    Anomalie
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($top_three_anomalies_for_boutique as $boutique)
                                <tr>
                                    <td>
                                        <a href="{{ url('visits/daily/'.$boutique->id) }}">{{ $boutique->updated_at ? $boutique->updated_at->format('d-m-Y') : '' }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('network/detail/boutique/'.$boutique->network->id) }}">{{ $boutique->network ? $boutique->network->name : '' }}</a>
                                    </td>
                                    <td>{{ $boutique->anomalies.' %' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{url('/networks')}}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 nnn">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Franchises</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table3">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">
                                    Anomalie
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($top_three_anomalies_for_franchise as $franchise)
                                <tr>
                                    <td>
                                        <a href="{{ url('visits/daily/'.$franchise->id) }}">{{ $franchise->updated_at ? $franchise->updated_at->format('d-m-Y') : '' }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('network/detail/franchise/'.$franchise->network->id) }}">{{ $franchise->network ? $franchise->network->name : '' }}</a>
                                    </td>
                                    <td>{{ $franchise->anomalies.' %' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{url('/networks')}}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 nnn">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Point de vente classique</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table4">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">
                                    Anomalie
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($top_three_anomalies_for_pdvc as $pdvc)
                                <tr>
                                    <td>
                                        <a href="{{ url('visits/daily/'.$pdvc->id) }}">{{ $pdvc->updated_at ? $pdvc->updated_at->format('d-m-Y') : '' }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('network/detail/pdv/'.$pdvc->network->id) }}">{{ $pdvc->network ? $pdvc->network->name : '' }}</a>
                                    </td>
                                    <td>{{ $pdvc->anomalies.' %' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{url('/networks')}}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 nnn">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Point de vente labellisé</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table5">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">
                                    Anomalie
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($top_three_anomalies_for_pdvl as $pdvl)
                                <tr>
                                    <td>
                                        <a href="{{ url('visits/daily/'.$pdvl->id) }}">{{ $pdvl->updated_at ? $pdvl->updated_at->format('d-m-Y') : '' }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ url('network/detail/pdv/'.$pdvl->network->id) }}">{{ $pdvl->network ? $pdvl->network->name : '' }}</a>
                                    </td>
                                    <td>{{ $pdvl->anomalies.' %' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <a href="{{url('/networks')}}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="margin: 20px;">
        <h3 class="page-title"> 10 dernières visites
            <small></small>
        </h3>

        <table class="table table-striped table-bordered table-hover" id="rapport_table6">
            <thead>
            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                <th style=" color: #F2784B; width: 10%;"> Date</th>
                <th style=" color: #F2784B; width: 15%;"> Reseau</th>
                <th style=" color: #F2784B; width: 8%; text-align: center; "> Type</th>
                <th style=" color: #F2784B; width: 10%; text-align: center;"> Zone</th>
                <th style=" color: #F2784B; width: 15%; text-align: center;"> Merchandiser</th>

                <th style=" color: #F2784B; width: 25%; text-align: center; valign:center;"> Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($ten_last_visits as $visit)
                <tr>
                    <td>{{ $visit->updated_at->format('d-m-Y') }}</td>
                    <td>
                        <?php
                        $type = $visit->network->type->code == 'pdvc' || $visit->network->type->code == 'pdvl' ? 'pdv' : $visit->network->type->code;
                        ?>
                        <a href="{{ url('network/detail/'.$type.'/'.$visit->network->id) }}">{{ $visit->network ? $visit->network->name : '' }}</a>
                    </td>
                    <td>{{ $visit->network ? ($visit->network->type ? $visit->network->type->value : '' ) : '' }}</td>
                    <td>{{ $visit->network ? ($visit->network->city ? $visit->network->city->zone->value : '' ) : '' }}</td>
                    <td>
                        @if($visit->user)
                            <a href="{{ route('profile.merchandiser', ['id' => $visit->user->id]) }}">{{ $visit->user->name }}</a>
                        @endif
                    </td>
                    <td style="text-align: center; valign:center;">
                        <a class="btn btn-sm {{ $visit->is_answered ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="Détail visite quotidienne" data-toggle="tooltip"
                           data-placement="top"
                           href="{{ url("visits/" . "daily" . "/" . $visit->id) }}"><i
                                    class="fa fa-calendar"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_branding ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="Détail visite branding"
                           href="{{ url("visits/" . "branding" . "/" . $visit->id) }}"><i
                                    class="fa fa-registered"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_display ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="Détail visite display"
                           href="{{ url("visits/" . "display" . "/" . $visit->id) }}"><i
                                    class="fa fa-tv"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_online ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="Détail visite online"
                           href="{{ url("visits/" . "online" . "/" . $visit->id) }}"><i
                                    class="fa fa-map-o"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_ilv ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="Détail visite ilv"
                           href="{{ url("visits/" . "ilv" . "/" . $visit->id) }}"><i
                                    class="icon-basket"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection


@section('footer')
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/flot/jquery.flot.min.js')?>"
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/flot/jquery.flot.resize.min.js')?>"
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/flot/jquery.flot.categories.min.js')?>"
            type="text/javascript"></script>
    <script>
        var visitors = visits_last_two_weeks;
        var oldvisitors = visits_last_four_weeks;
        function showChartTooltip(x, y, xValue, yValue) {
            $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 40,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff'
            }).appendTo("body").fadeIn(200);
        }

        if ($('#site_statistics').size() != 0) {

            $('#site_statistics_loading').hide();
            $('#site_statistics_content').show();

            var plot_statistics = $.plot($("#site_statistics"), [{
                        data: visitors,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#f89f9f']
                    }, {
                        data: visitors,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#f89f9f",
                            lineWidth: 3
                        },
                        color: '#fff',
                        shadowSize: 0
                    }, {
                        data: oldvisitors,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#88aef3']
                    }, {
                        data: oldvisitors,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#88aef3",
                            lineWidth: 3
                        },
                        color: '#fff',
                        shadowSize: 0
                    }],

                    {
                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

            var previousPoint = null;
            $("#site_statistics").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);

                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' visits');
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        }

        /*visit stats*/
        var visit_effecute = visits_last_two_weeks;
        var visit_planified = planned_visits_two_weeks;
        function showChartTooltip(x, y, xValue, yValue) {
            $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                position: 'absolute',
                display: 'none',
                top: y - 40,
                left: x - 40,
                border: '0px solid #ccc',
                padding: '2px 6px',
                'background-color': '#fff'
            }).appendTo("body").fadeIn(200);
        }

        if ($('#visit_statistics').size() != 0) {

            $('#visit_statistics_loading').hide();
            $('#visit_statistics_content').show();

            var plot_statistics = $.plot($("#visit_statistics"), [{
                        data: visit_effecute,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#f89f9f']
                    }, {
                        data: visit_effecute,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#f89f9f",
                            lineWidth: 3
                        },
                        color: '#fff',
                        shadowSize: 0
                    },
                        {
                            data: visit_planified,
                            lines: {
                                fill: 0.6,
                                lineWidth: 0
                            },
                            color: ['#9ACAE6']
                        }, {
                            data: visit_planified,
                            points: {
                                show: true,
                                fill: true,
                                radius: 5,
                                fillColor: "#9ACAE6",
                                lineWidth: 3
                            },
                            color: '#fff',
                            shadowSize: 0
                        }],

                    {
                        xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

            var previousPoint = null;
            $("#visit_statistics").bind("plothover", function (event, pos, item) {
                $("#x").text(pos.x.toFixed(2));
                $("#y").text(pos.y.toFixed(2));
                if (item) {
                    if (previousPoint != item.dataIndex) {
                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);

                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' visits');
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        }

        /********TAB 1**********/
        $.fn.dataTable.ext.errMode = 'throw';
        var table1 = $('#rapport_table1').DataTable({
            "processing": false,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table2 = $('#rapport_table2').DataTable({
            "processing": false,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table3 = $('#rapport_table3').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table4 = $('#rapport_table4').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table5 = $('#rapport_table5').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table6 = $('#rapport_table6').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });

        /********TAB 3**********/
    </script>

@endsection
@section('after-scripts-end')
@stop