@extends('frontend.layouts.master')

@section('second-title')
    | Détails visite du {{ $visit->visit_date->format('d/m/Y') }}
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visits/ilv')}}">Visites ILV</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $visit->visit_date->format('d/m/Y') }}</a>
    </li>
@stop


@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/portfolio.min.css')?> " rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')
    <?php $is_answered = $visit->is_answered_ilv; ?>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i><span class="caption-subject bold uppercase">Details visite ILV </span>
                        @if($is_answered)
                            <small style="font-size: 14px;letter-spacing: 0;font-weight: 300; color: #888;">Envoyée
                                le {{ $visit->updated_at }}</small>
                        @endif
                    </div>
                    <div class="tools">
                        <div class="dt-buttons">
                            @permission('add-visits')
                            @if(!$is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('visits/ilv/add/'.$visit->id) }}"><i class="fa fa-plus-circle"></i>
                                    Ajouter une réponse</a>
                                @permission('edit-visits')
                                <a class="dt-button buttons-print btn blue-chambray btn-outline" data-target="#pop_up"
                                   data-toggle="modal" style="padding-left: 3px; "> <i class="fa fa-edit"></i> Editer
                                    date
                                </a>
                                @endauth
                            @endif
                            @endauth
                            @permission('edit-visits')
                            @if($is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('visits/ilv/edit/'.$visit->id) }}"><i
                                            class="fa fa-edit"></i> Editer
                                    la réponse</a>
                            @endif
                            @endauth
                            @role('Merch')
                            @if($is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('visits/ilv/edit/'.$visit->id) }}"><i
                                            class="fa fa-edit"></i> Editer
                                    la réponse</a>
                            @endif
                            @endauth
                            @if($supervisor_note == true)
                                <a tabindex="0" class="dt-button buttons-print btn blue btn-outline"
                                   data-target="#msg_form" data-toggle="modal"><span><i
                                                class="fa fa-sticky-note-o"></i> Note superviseur</span></a>
                            @endif
                            <a tabindex="0" class="dt-button buttons-print btn red btn-outline"
                               aria-controls="sample_1"><span><i
                                            class="fa fa-file-pdf-o"></i> PDF</span></a>
                            <a tabindex="0" class="dt-button buttons-print btn blue btn-outline"
                               aria-controls="sample_1"><span><i class="fa fa-print"></i> Imprimer</span></a>

                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->code : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->name : ''}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network->type->value }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser : </b></label></br>
                                <label class="control-label">{{ $visit->user->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Zone
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->city->zone->value : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Adresse
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network->address }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Ville : </b></label></br>
                                <label class="control-label">{{ $visit->network->city->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite quotidienne"
                               href="{{ url('visits/daily/'.$visit->id) }}"><i
                                        class="fa fa-calendar"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite display"
                               href="{{ url('visits/display/'.$visit->id) }}"><i
                                        class="fa fa-tv"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite online"
                               href="{{ url('visits/online/'.$visit->id) }}"><i
                                        class="fa fa-map-o"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                               href="{{ url('visits/branding/'.$visit->id) }}"><i
                                        class="fa fa-registered"></i></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">

                        </div>

                    </div>


                    <table class="table table-striped table-bordered table-hover" id="rapport_table">
                        @if($is_answered)
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 60%;text-align: center"> Nom</th>
                                <th style=" color: #F2784B; width: 60%;text-align: center"> Date de la visite</th>
                                <th style=" color: #F2784B; width: 20%;text-align: center"> Photo</th>
                                <th style=" color: #F2784B; width: 20%;text-align: center"> Etat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($ilv_networks))
                                @foreach($ilv_networks as $ilv_network)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/ilv/detail/'.$ilv_network['id']) }}"> {{ $ilv_network['name'] }}</a>
                                        </td>
                                        <td>{{ $ilv_network['date'] }}</td>
                                        <td>
                                            <a class="btn dark" data-toggle="modal"
                                               data-target="#img_reviewer"
                                               onclick='set_link("{{ $ilv_network['photo'] ? url($ilv_network['photo']) : '' }}") '><i
                                                        class="fa fa-search"></i> Aperçu </a>
                                        </td>
                                        @if($ilv_network['status'] == true)
                                            <td style="text-align: center"><span class="btn green">Disponible</span>
                                            </td>
                                        @elseif($ilv_network['status'] == false)
                                            <td style="text-align: center"><span class="btn red">En rupture</span>
                                            </td>
                                        @endif
                                    </tr>

                            @endforeach
                        @endif
                        @else
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 60%;"> Nom</th>
                                <th style=" color: #F2784B; width: 60%;text-align: center"> Photo</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center"> Etat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($ilvs))
                                @foreach($ilvs as $ilv)
                                    <tr>
                                        <td><a href="{{ url('/ilv/detail/'.$ilv->id) }}">{{ $ilv->name }}</a></td>
                                        <td>
                                            <a class="btn dark" data-toggle="modal"
                                               data-target="#img_reviewer"
                                               onclick='set_link("{{ $ilv->photo ? url($ilv->photo->path) : '' }}") '><i
                                                        class="fa fa-search"></i> Aperçu </a>
                                        </td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        @endif
                    </table>
                    <!-- ///////////////////////////////////// image reviewer ////////////////////////////// -->
                    <div class="modal fade" id="img_reviewer" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title" id="img_title"></h4>
                                </div>
                                <div class="modal-body"><img id="img_pop" style="display: block; width: 98%; " src=""
                                                             alt=""></div>
                                <div class="modal-footer">
                                    <h5 class="modal-title" id="img_footer" style="text-align: left"></h5>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
@section('footer')
    <script>

        $('.date-picker').datepicker();

    </script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>
    <script>
        $('#rapport_table').DataTable({
            "bPaginate": false,
            "bInfo": false,
            "bFilter": true,
            responsive: true,
            "columnDefs": [
                {
                    "targets": [1],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [2],
                    "className": 'dt-body-center'
                }
            ]
        });
    </script>
    <script>
        function set_link(link) {
            if (decodeURIComponent(link) != "") {
                document.getElementById("img_pop").setAttribute("src", decodeURIComponent(link));
            }
            else {
                return false;
            }
        }
    </script>

@endsection