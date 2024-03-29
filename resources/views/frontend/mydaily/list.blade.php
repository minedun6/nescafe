@extends('frontend.layouts.master')
@section('header')
@endsection
@section('second-title')
    | MES VISITES DE JOUR
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/mydaily')}}">Visites du jour</a>
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
                        <span class="caption-subject bold uppercase">Mes visites de jour </span>
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
                                    @role('Merch')
                                    @else
                                        <td style="padding-left: 5px;text-align: center;"><label  style="margin-top: 5px;" for="date"
                                                    >
                                                Marchandiser </label></td>
                                        <td width="10%"><select type="text" name="merch" id="merch" onchange="table.draw();"
                                                                class="form-control form-control-inline  "
                                                    >
                                                <option></option>
                                                @foreach($merchs as $merch)
                                                    <option>{{ $merch->name }}</option>
                                                @endforeach
                                            </select></td>
                                        @endauth

                                    <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                             style="margin-top: 5px;">
                                            Reseau </label></td>
                                    <td width="10%"><input type="text" name="network" id="network"
                                                           class="form-control form-control-inline  "
                                                           oninput="table.draw();"></td>
                                    <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                             style="margin-top: 5px;">
                                            Type </label></td>
                                    <td width="10%"><input type="text" name="type" id="type"
                                                           class="form-control form-control-inline  "
                                                           oninput="table.draw();"></td>
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
                    <div class="row" style="margin-top: 20px;">

                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 7%;"> Date</th>
                                <th style=" color: #F2784B; width: 10%;"> Reseau</th>
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

    </script>

    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
		
		$('.select').chosen({no_results_text: "Oops, pas de résultats!"});
        $.fn.dataTable.ext.errMode = 'throw';
        var table = $('#rapport_table').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 10,
            "bFilter": false,
            "bSort":false,
            "ajax": {
                'url': "{{ url('/getmydaily') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.network = document.getElementById('network').value;
                    d.type = document.getElementById('type').value;
                    d.zone = document.getElementById('zone').value;
                    if (document.getElementById('merch'))
                        d.merch = document.getElementById('merch').value;
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