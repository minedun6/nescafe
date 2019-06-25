@extends('frontend.layouts.master')
@section('second-title')
    | Dashboard
@stop

@section('url-way')
    <li>
        <a href="#">Dashboard</a>
    </li>
    @stop

    @section('content')
            <!-- BEGIN PAGE TITLE-->
    <h3 class="page-title"> Dashboard
        <small></small>
    </h3>
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <style>
        .dataTables_info {
            display: none;
        }
    </style>
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="col-md-12">
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
                    <div class="desc"> Visites (dernier mois)</div>
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

                        <span data-counter="counterup">{{ $boutiques_number_with_anomalies }}</span></div>
                    <div class="desc"> Boutiques dépassant 20% d'anomalie</div>
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

                        <span data-counter="counterup">{{ $franchises_number_with_anomalies }}</span></div>
                    <div class="desc"> Franchises dépassant 20% d'anomalie</div>

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
                        <span data-counter="counterup">{{ $pdvc_number_with_anomalies }}</span></div>
                    <div class="desc"> PDV classique dépassant 40% d'anomalie</div>

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
                        <span data-counter="counterup">{{ $pdvl_number_with_anomalies }}</span></div>

                    <div class="desc">PDV labelisé dépassant 30% d'anomalie</div>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->

    <div class="row" style="margin: 20px;">
        <h3 class="page-title"> TOP 3 des anomalies
            <small>Par type réseaux</small>
        </h3>

        <div class="col-md-6">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Boutiques</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table2">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">Anomalie
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
                        <a href="{{ url('networks') }}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Franchises</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table3">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">Anomalie
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
                        <a href="{{ url('networks') }}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Point de vente classique</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table4">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">Anomalie
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
                        <a href="{{ url('networks') }}" style="float:right;">Voir plus ...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <div class="mt-element-ribbon bg-grey-steel">
                    <div class="ribbon ribbon-color-danger uppercase ">Point de vente labellisé</div>
                    <div style="margin-top:30px;">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table5">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 30%;"> Date</th>
                                <th style=" color: #F2784B; width: 50%;"> Reseau</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">Anomalie
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
                        <a href="{{ url('networks') }}" style="float:right;">Voir plus ...</a>
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
                           id="btn-detail" title="D�tail visite quotidienne" data-toggle="tooltip"
                           data-placement="top"
                           href="{{ url("visits/" . "daily" . "/" . $visit->id) }}"><i
                                    class="fa fa-calendar"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_branding ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="D�tail visite branding"
                           href="{{ url("visits/" . "branding" . "/" . $visit->id) }}"><i
                                    class="fa fa-registered"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_display ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="D�tail visite display"
                           href="{{ url("visits/" . "display" . "/" . $visit->id) }}"><i
                                    class="fa fa-tv"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_online ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="D�tail visite online"
                           href="{{ url("visits/" . "online" . "/" . $visit->id) }}"><i
                                    class="fa fa-map-o"></i></a>
                        <a class="btn btn-sm {{ $visit->is_answered_ilv ? 'green-jungle' : 'dark' }}"
                           id="btn-detail" title="D�tail visite ilv"
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

        $.fn.dataTable.ext.errMode = 'throw';
        /********TAB 1**********/
        var table = $('#rapport_table2').DataTable({
            "processing": false,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table = $('#rapport_table3').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table = $('#rapport_table4').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table = $('#rapport_table5').DataTable({
            "processing": true,
            "serverSide": false,
            "iDisplayLength": 5,
            "bPaginate": false,
            "bFilter": false,
            "bSort": false,
            "responsive": true,
        });
        /********TAB 1**********/
        var table = $('#rapport_table6').DataTable({
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