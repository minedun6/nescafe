@extends('frontend.layouts.master')
@section('second-title')
    | ILV {{ $ilv->name }}
@stop
@section('url-way')
    <li>
        <a href="{{url('/ilv')}}">ILV</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $ilv->name }}</a>
    </li>
@stop
@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/blog.min.css')?> " rel="stylesheet" type="text/css"/>
@endsection
@section('title')
    ILV
@endsection
@section('content')
    <div class="row">
        <a class="dt-button buttons-print btn dark btn-outline"
           data-target="#pop_up" data-toggle="modal" style="float: right; margin-right: 10px;"><i
                    class="fa fa-plus-circle"></i>
            Ajouter un approvisionnement</a>
        <a class="dt-button buttons-print btn blue btn-outline"
           href="{{ url('/ilv/edit/'.$ilv->id) }}" style="float: right; margin-right: 10px;"><i class="fa fa-edit"></i>
            Editer</a>
        <a class="dt-button buttons-remove btn red btn-outline"
           href="{{ url('/ilv/deactivate/'.$ilv->id) }}" style="float: right; margin-right: 10px;"><i
                    class="fa fa-remove"></i>
            Désactiver</a>
    </div>
    <div class="tabbable-line" id="tabs">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab_15_1" data-toggle="tab"> Détails </a>
            </li>
            <li class="">
                <a href="#tab_15_2" data-toggle="tab"> Etat </a>
            </li>
            <li class="">
                <a href="#tab_15_3" data-toggle="tab"> Approvisionnements </a>
            </li>
            <li class="">
                <a href="#tab_15_4" data-toggle="tab"> Statistiques</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_15_1">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="portlet dark box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info"></i>Détails ilv
                                </div>
                                <div class="actions">

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Nom :</div>
                                    <div class="col-md-7 value">
                                        {{ $ilv->name }}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Type réseau:</div>
                                    <div class="col-md-7 value"> {{ $ilv->networkType ? $ilv->networkType->value : '' }} </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Cible:</div>
                                    <div class="col-md-7 value">
                                        {{ $ilv->target ? $ilv->target : '' }}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Quantité:</div>
                                    <div class="col-md-7 value">
                                        {{ $stock }}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Notifier en cas de rupture ?</div>
                                    <div class="col-md-7 value">
                                        @if($ilv->should_notify)
                                            Oui
                                        @else
                                            Non
                                        @endif
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 50px;">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="blog-img-thumb" style="text-align: center">
                                            @if($ilv->photo != null)
                                                <a href="javascript:;">
                                                    <img src="{{ url($ilv->photo->path) }}"
                                                         style="width: 60%">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="tab-pane" id="tab_15_2">
                <div class="row" style="margin-top: 20px;">
                    <div class="portlet light">
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="ilv_table">
                                <thead>
                                <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                    <th style="  width: 25%;"> Nom</th>
                                    <th style="  width: 25%;"> Date de la visite</th>
                                    <th style="  width: 25%;text-align: center;"> Etat</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="tab_15_3">
                <div class="row" style="margin-top: 20px;">
                    <div class="portlet light">
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="appro_table">
                                <thead>
                                <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                    <th style=" width: 30%;"> Date</th>
                                    <th style=" width: 30%;"> Quantité</th>
                                    <th style=" width: 30%;text-align: center"> Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <div class="modal fade" id="pop_up_edit_0" tabindex="-1" role="basic"
                                     aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true"></button>
                                                <h4 class="modal-title" style="color: #F2784B;"> Approvisionnement</h4>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" method="post" action="{{ url('/appro/edit/') }}"
                                                      id="appro_edit_form">
                                                    {{ csrf_field() }}
                                                    <label for="message">la nouvelle quantité
                                                        <input class="form-control form-control-inline" type="text"
                                                               name="quantity" value=""/></label>
                                                    <input type="hidden" name="appro_id" id="appro_id" value="">
                                                    <div class="modal-footer">
                                                        <button class="btn dark" type="submit">Editer
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="tab_15_4">
                <div class="row" style="margin-top: 20px;">
                    <div class="portlet light">
                        <div class="portlet-body">
                            <form id="myform2" style="margin-bottom: 30px;">
                                <table id="mytable2" style="margin: auto;">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><label for="date" style="margin: 5px 20px 0 40px;">
                                                Date </label></td>
                                        <td style="padding-left:5px;" id="row2"><input type="text"
                                                                                       style="margin-bottom: 3px;"
                                                                                       name="date"
                                                                                       id="date"
                                                                                       class="form-control form-control-inline  date-picker"
                                                                                       onchange="reload();"
                                                                                       placeholder="De">
                                            <input type="text" name="datefin" id="datefin"
                                                   class="form-control form-control-inline  date-picker"
                                                   onchange="reload();"
                                                   placeholder="à"></td>

                                        <td style="padding-left: 5px;text-align: center;"><label
                                                    for="date"
                                                    style="margin: 5px 20px 0 40px;">
                                                Type de Réseau </label></td>
                                        <td><select type="text" name="network_type" id="network_type"
                                                    onchange="reload();"
                                                    class="form-control form-control-inline">
                                                <option value=""></option>
                                                @foreach($network_types as $network_type)
                                                    <option value="{{ $network_type->id }}">{{ $network_type->value }}</option>
                                                @endforeach
                                            </select></td>

                                        <td style="padding-left: 5px;text-align: center;"><label
                                                    for="date"
                                                    style="margin: 5px 20px 0 40px;">
                                                Zone </label></td>
                                        <td>
                                            <select name="zone" id="zone"
                                                    class="form-control form-control-inline  select"
                                                    onchange="reload();">
                                                <option value="">Tous</option>
                                                @foreach($zones as $zone)
                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                @endforeach
                                            </select>
										</td>

                                        <td style="padding-left: 5px;text-align: center;">
                                            <button class="btn dark" onclick="netoyer()"
                                                    id="btn-reset">
                                                Annuler
                                            </button>
                                        </td>

                                    </tr>
                                    </tbody>

                                </table>
                            </form>
                            <style>
                                #chartdiv {
                                    width: 100%;
                                    height: 500px;
                                    font-size: 11px;
                                }

                                [title="JavaScript charts"] {
                                    display: none;
                                }
                            </style>
                            <div id="chartdiv"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal fade" id="pop_up" tabindex="-1" role="basic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true"></button>
                            <h4 class="modal-title" style="color: #F2784B;"> Nouveau approvisionnement</h4>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" action="{{ url('/appro/add/'.$ilv->id) }}">
                                {{ csrf_field() }}
                                <label for="message">Quantité à ajouter
                                    <input class="form-control form-control-inline" name="quantity" type="text"
                                           value=""/></label>
                                <div class="modal-footer">
                                    <button class="btn dark" type="submit">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $('.date-picker').datepicker();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        var today = dd + '/' + mm + '/' + yyyy;

        var old = new Date();
        old.setMonth(old.getMonth() - 3);
        var ddp = old.getDate();
        var mmp = old.getMonth() + 1; //January is 0!
        var yyyyp = old.getFullYear();
        if (ddp < 10) {
            ddp = '0' + ddp
        }
        if (mm < 10) {
            mmp = '0' + mmp
        }

        var past = ddp + '/' + mmp + '/' + yyyyp;


        document.getElementById('datefin').value = today;
        document.getElementById('date').value = past;
		$('.tab-pane').addClass('active') ;
		$('.select').chosen({no_results_text: "Oops, pas de résultats!"});
		$('.tab-pane').removeClass('active') ;
		$('#tab_15_1').addClass('active') ;
		
    </script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/amcharts/amcharts/amcharts.js')?>"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/amcharts/amcharts/pie.js')?>"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/amcharts/amcharts/themes/light.js')?>"></script>

    <script>
        $(function () {
            $('#ilv_table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
                "iDisplayLength": 10,
                "bFilter": true,
                "bSort": false,
                "ajax": {
                    'url': "{{ url('/ilv_network/paginate/'.$ilv->id) }}",
                    'type': 'get',
                    'data': function (d) {
                        d.page = Math.ceil(d.start / d.length) + 1;
                    }
                },
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [2],
                        "className": 'dt-body-center'
                    }
                ]
            });
            $('#appro_table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
                "iDisplayLength": 10,
                "bFilter": true,
                "bSort": false,
                "ajax": {
                    'url': "{{ url('/appro/paginate/'.$ilv->id) }}",
                    'type': 'get',
                    'data': function (d) {
                        d.page = Math.ceil(d.start / d.length) + 1;
                    }
                },
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [2],
                        "className": 'dt-body-center'
                    }
                ]
            });
            $("a[title=\"JavaScript charts\"]").removeAttr('style');
            $(document).on('click', '.edit-button', function () {
                var appro_id = $(this).data('id');
                $("#appro_id").val(appro_id);
            });

        });

        function reload() {
            $.ajax({
                type: 'get',
                url: "{{ route('ilv.stats.availability', $ilv->id) }}",
                dataType: 'json',
                data: {
                    "zone": document.getElementById('zone').value,
                    "datedebut": document.getElementById('date').value,
                    "datefin": document.getElementById('datefin').value,
                    "network_type": document.getElementById('network_type') ? document.getElementById('network_type').value : ''
                },
                success: function (data) {
                    chart.dataProvider = data;
                    chart.validateData();
                }
            });
        }

        var data = reload();

        var chart = AmCharts.makeChart("chartdiv", {
            "type": "pie",
            "theme": "light",
            "dataProvider": data,
            "valueField": "pourcentage",
            "colorField": "color",
            "titleField": "type",
            "export": {
                "enabled": true
            },
            "listeners": [{
                "event": "clickSlice",
                "method": function (event) {
                    console.log(event.dataItem.title)
                }
            }]
        });
    </script>
@endsection