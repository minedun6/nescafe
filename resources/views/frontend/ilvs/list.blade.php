@extends('frontend.layouts.master')

@section('second-title')
    | ILV
@stop
@section('url-way')
    <li>
        <a href="{{url('/ilv')}}">ILV</a>
    </li>
@stop

@section('header')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Liste des ILVs</span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('/ilv/add') }}" class="btn btn-sm dark"><i
                                    class="fa fa-plus"></i> Ajouter ILV</a>
                    </div>

                </div>
                <div class="portlet-body">

                    <div class="row" style="margin-top: 20px;">
							<form id="myform" style="margin-bottom: 30px;">
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
                                                                   class="form-control form-control-inline date-picker"
                                                                   onchange="table.draw();"
                                                                   placeholder="De">
                                                            <input type="text" name="datefin" id="datefin"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table.draw();"
                                                                   placeholder="à"></td>

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
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style="  width: 30%;"> Nom</th>
                                <th style="  width: 20%;"> Réseau / Cible</th>
                                <th style="  width: 5%; text-align: center; "> Quantité</th>
                                <th style="  width: 5%; text-align: center; "> Disponibilité</th>
                                <th style="  width: 20%; text-align: center;"> Actions</th>
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

@endsection
@section('footer')
	<script>$('.date-picker').datepicker();</script>
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
            "bFilter": true,
            "bSort": false,
            "ajax": {
                'url': "{{ url('/ilv/paginate') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
					d.datedebut = document.getElementById('date').value;
                    d.datefin = document.getElementById('datefin').value;

                }
            },
            responsive: true,
            "columnDefs": [
                {
                    "targets": [2, 3],
                    "className": 'dt-body-center'
                }
            ]
        });

    </script>
@endsection