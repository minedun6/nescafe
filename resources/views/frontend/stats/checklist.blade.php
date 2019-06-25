@extends('frontend.layouts.master')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
@section('second-title')
    | Stats Visites
@stop
@section('url-way')
    <li>
        <a href="#">Statistiques</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ url('/checklists')}}">Tâches </a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $task->checkList ? $task->checkList->name : '' }}</a>
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
                        <span class="caption-subject bold uppercase">Statistiques {{ $task->checkList ? $task->checkList->name : '' }} </span><br/><br/>
                        <div class="row">
                            <div class="col-md-12" style="font-size: 15px;"><b></b> {{ $task->description }}</div>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="myform1" class="xxxx" style="margin-bottom: 30px;">
                                <table id="mytable1" style="margin:auto;">
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
                                        <td style="padding-left:5px;" id="row2">
                                            <input type="text"
                                                   style="margin-bottom: 3px;"
                                                   name="date" id="date"
                                                   class="form-control form-control-inline  date-picker"
                                                   onchange="change();document.getElementById('datefin').value=this.value;"
                                                   placeholder="De">
                                            <input type="text" name="datefin" id="datefin"
                                                   class="form-control form-control-inline  date-picker"
                                                   onchange="change();"
                                                   placeholder="à"></td>

                                        <td style="padding-left: 5px;text-align: center;"><label
                                                    for="date"
                                                    style="margin: 5px 20px 0 40px;">
                                                Nom du Réseau </label></td>
                                        <td>
                                            <div class="ui-widget">
                                                <input type="text" name="network" id="network"
                                                       oninput="change();" class="form-control form-control-inline">
                                            </div>
                                        </td>
                                        <!-- <td style="padding-left: 5px;text-align: center;"><label
                                                     for="date"
                                                     style="margin: 5px 20px 0 40px;">
                                                 Zone </label></td>-->
                                        <td><label for="date" style="margin: 5px 20px 0 40px;">
                                                Zone </label></td>
                                        <td>
                                            <select name="zone" id="zone"
                                                    class="form-control form-control-inline  select"
                                                    onchange="change();">
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

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <!-- BEGIN PORTLET-->
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bar-chart font-green"></i>
                                        <span class="caption-subject font-green bold uppercase">Anomalies </span>
                                        <span class="caption-helper"></span>
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

                </div>
            </div>
        </div>
    </div></div>

@endsection
@section('footer')
    <script>
        $('.date-picker').datepicker();
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        $('.select').chosen({no_results_text: "Oops, pas de résultats!"});
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
        if (mmp < 10) {
            mmp = '0' + mmp
        }

        var past = ddp + '/' + mmp + '/' + yyyyp;


        document.getElementById('datefin').value = today;
        document.getElementById('date').value = past;
    </script>

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
        //var visitors = visits_last_two_weeks;
        var data = change();
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
                        data: data,
                        lines: {
                            fill: 0.6,
                            lineWidth: 0
                        },
                        color: ['#f89f9f']
                    }, {
                        data: data,
                        points: {
                            show: true,
                            fill: true,
                            radius: 5,
                            fillColor: "#f89f9f",
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

                        showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + ' %');
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }
            });
        }

        function change() {
            $('#site_statistics_loading').show();
            $('#site_statistics_content').hide();
            $.ajax({
                type: 'get',
                url: "{{ route('stats.on.checklist', $task->id) }}",
                dataType: 'json',
                data: {
                    "zone": document.getElementById('zone').value,
                    "datedebut": document.getElementById('date').value,
                    "datefin": document.getElementById('datefin').value,
                    "network": document.getElementById('network') ? document.getElementById('network').value : ''
                },
                success: function (data) {
                    $('#site_statistics_loading').hide();
                    $('#site_statistics_content').show();
                    plot_statistics = $.plot($("#site_statistics"), [{
                                data: data,
                                lines: {
                                    fill: 0.6,
                                    lineWidth: 0
                                },
                                color: ['#f89f9f']
                            }, {
                                data: data,
                                points: {
                                    show: true,
                                    fill: true,
                                    radius: 5,
                                    fillColor: "#f89f9f",
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
                }
            });
        }

        $(function () {
            $("#network").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{ route('autocomplete.networks') }}",
                        dataType: "json",
                        data: {
                            network: request.term,
                            zone: $("#zone").val(),
                            'network_type': "{{ $task->checkList ? $task->checkList->network_type_id : '' }}"
                        },
                        success: function (data) {
                            var results = $.ui.autocomplete.filter(data, request.term);
                            response(results.slice(0, 10));
                        }
                    });
                },
                minLength: 3,
                select: function (event, ui) {
                    $('#network').val(ui.item.label);
                    change();
                }
            });
        });
    </script>
@endsection
@section('after-scripts-end')
@stop