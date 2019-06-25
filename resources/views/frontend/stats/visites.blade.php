@extends('frontend.layouts.master')
@section('second-title')
    | Stats Visites
@stop
@section('url-way')
    <li>
        <a href="#">Statistiques</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visites')}}">Visites</a>
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
                        <span class="caption-subject bold uppercase">Statistiques des visites </span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <form id="myform">
                            <table id="mytable" style="">
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
                                    <td width="3%"><label for="date" style="margin-top: 5px;"> Date </label></td>
                                    <td width="15%" style="padding-left:5px;" id="row2">
                                        <input type="text"
                                               style="margin-bottom: 3px;"
                                               name="date" id="date"
                                               class="form-control form-control-inline  date-picker"
                                               onchange="table.draw();document.getElementById('datefin').value=this.value;"
                                               placeholder="De">
                                        <input type="text" name="datefin" id="datefin"
                                               class="form-control form-control-inline  date-picker"
                                               onchange="table.draw();"
                                               placeholder="à"></td>

                                    @role('Merch')
                                    @else
                                        <td style="padding-left: 5px;text-align: center;"><label
                                                    style="margin-top: 5px;" for="date"
                                            >
                                                Marchandiser </label></td>
                                        <td width="10%"><select type="text" name="merch" id="merch"
                                                                onchange="table.draw();"
                                                                class="form-control form-control-inline  "
                                            >
                                                <option></option>
                                                @foreach($merchs as $merch)
                                                    <option value="{{ $merch->id }}">{{ $merch->name }}</option>
                                                @endforeach
                                            </select></td>
                                        @endauth

                                        <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                                 style="margin-top: 5px;">
                                                Réseau </label></td>
                                        <td width="10%"><input type="text" name="network" id="network"
                                                               class="form-control form-control-inline  "
                                                               oninput="table.draw();"></td>
                                        <td style="padding-left: 5px;text-align: center;"><label for="network_type"
                                                                                                 style="margin-top: 5px;">
                                                Type de Réseau </label></td>
                                        <td width="10%"><select type="text" name="network_type" id="network_type"
                                                                onchange="table.draw();"
                                                                class="form-control form-control-inline  select">
                                                <option value="">Tous</option>
                                                @foreach($network_types as $network_type)
                                                    <option value="{{ $network_type->id }}">{{ $network_type->value }}</option>
                                                @endforeach
                                                <option value="vd">VD</option>
                                                <option value="vi">VI</option>
                                            </select></td>
                                        <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                                 style="margin-top: 5px;">
                                                Zone </label></td>
                                        <td width="10%">
                                            <select name="zone" id="zone"
                                                    class="form-control form-control-inline  select"
                                                    onchange="table.draw();">
                                                <option value="">Tous</option>
                                                @foreach($zones as $zone)
                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td style="padding-left: 5px;text-align: center;">
                                            <button class="btn dark" onclick="netoyer()" id="btn-reset">
                                                Annuler
                                            </button>
                                        </td>
                                </tr>
                                </tbody>

                            </table>
                        </form>

                    </div>
                    <div class="row" style="margin-top:20px;">
                        <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12">
                            <div class="dashboard-stat blue">
                                <div class="visual">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup" id="newvisits"></span>
                                    </div>
                                    <div class="desc"> Visites</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-2 col-sm-6 col-xs-12">
                            <div class="dashboard-stat red">
                                <div class="visual">
                                    <i class="fa fa-warning"></i>
                                </div>
                                <div class="details">
                                    <a href="/checklists">
                                    <div class="number">
                                        <span data-counter="counterup" id="newanomalies"></span>%
                                    </div>
                                    <div class="desc"> Anomalies</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">

                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 7%;"> Date</th>
                                <th style=" color: #F2784B; width: 10%;"> Réseau</th>
                                <th style=" color: #F2784B; width: 8%; text-align: center; "> Type</th>
                                <th style=" color: #F2784B; width: 5%; text-align: center;"> Zone</th>
                                <th style=" color: #F2784B; width: 10%; text-align: center;"> Merchandiser</th>
                                <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;"> Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div></div>
    <div class="modal fade" id="msg_form" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title" style="color: #F2784B;"> Message</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="" onsubmit="">

                        <label for="message">Message</label>
                        <textarea class="form-control" name="message" id="message" rows="2"></textarea>


                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn dark" type="submit">Envoyer</button>

                </div>

            </div>
            <!-- /.modal-content -->
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
        if (mmp < 10) {
            mmp = '0' + mmp
        }

        var past = ddp + '/' + mmp + '/' + yyyyp;


        document.getElementById('datefin').value = today;
        document.getElementById('date').value = past;
        $('.select').chosen({no_results_text: "Oops, pas de résultats!"});
    </script>

    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $.fn.dataTable.ext.errMode = 'throw';
        var table = $('#rapport_table').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 10,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('ajax.stats.visits') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.network = document.getElementById('network').value;
                    d.zone = document.getElementById('zone').value;
                    d.datedebut = document.getElementById('date').value;
                    d.datefin = document.getElementById('datefin').value;
                    if (document.getElementById('merch'))
                        d.merch = document.getElementById('merch').value;
                    if (document.getElementById('network_type'))
                        d.network_type = document.getElementById('network_type').value;
                },
                complete: function (data) {
                    document.getElementById('newvisits').innerHTML = data.responseJSON.recordsTotal;
                    document.getElementById('newanomalies').innerHTML = data.responseJSON.anomalies;
                }

            },
            responsive: true,
            "columnDefs": [
                {
                    "targets": [5],
                    "className": 'dt-body-center'
                }
            ]
        });


        function netoyer() {
            document.getElementById("myform").reset();
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {
                        return true;
                    }
            );
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function (settings, data, dataIndex) {
                return true;
            }));
            table.draw();
        }
    </script>

@endsection
@section('after-scripts-end')
@stop