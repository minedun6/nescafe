﻿@extends('frontend.layouts.master')
@section('second-title')
    | Stats checklists
@stop
@section('url-way')
    <li>
        <a href="#">Statistiques</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/checklists')}}">Checklists</a>
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
                        <span class="caption-subject bold uppercase">Stats sur les checklists </span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" style="margin-top: 20px;">
                        <div class="tabbable-line" id="tabs">
                            <ul class="nav nav-tabs ">
                                <li class="active">
                                    <a href="#tab_15_1" data-toggle="tab" aria-expanded="true"> Boutique </a>
                                </li>
                                <li class="">
                                    <a href="#tab_15_2" data-toggle="tab" aria-expanded="false"> Franchise</a>
                                </li>
                                <li class="">
                                    <a href="#tab_15_3" data-toggle="tab"> PDV Classique </a>
                                </li>
                                <li class="">
                                    <a href="#tab_15_4" data-toggle="tab" aria-expanded="false" id="tab1">PDV
                                        Labelisé</a>
                                </li>
                                <li class="">
                                    <a href="#tab_15_5" data-toggle="tab" aria-expanded="false" id="tab2"> Smart </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_15_1">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="myform1" style="margin-bottom: 30px;">
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
                                                                   name="date" id="date1"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table1.draw();document.getElementById('datefin1').value=this.value;"
                                                                   placeholder="De">
                                                            <input type="text" name="datefin" id="datefin1"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table1.draw();"
                                                                   placeholder="à"></td>

                                                        <td style="padding-left: 5px;text-align: center;"><label
                                                                    for="date"
                                                                    style="margin: 5px 20px 0 40px;">
                                                                Zone </label></td>
                                                        <td><select name="zone" id="zone1"
                                                                    class="form-control form-control-inline  select"
                                                                    onchange="table1.draw();">
                                                                <option value="">Tous</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer(1)"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>


                                            <table class="table table-striped table-bordered table-hover"
                                                   id="rapport_table1">
                                                <thead>
                                                <th width="15%">Catégorie</th>
                                                <th width="15%">Sous-catégorie</th>
                                                <th width="30%" style="text-align: center">Description</th>
                                                <th width="15%" style="text-align: center">B.Merch</th>
                                                <th width="15%" style="text-align: center">Anomalies</th>
                                                <th width="10%" style="text-align: center">Action</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_15_2">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                                                                                       id="date2"
                                                                                                       class="form-control form-control-inline  date-picker"
                                                                                                       onchange="table2.draw();document.getElementById('datefin2').value=this.value;"
                                                                                                       placeholder="De">
                                                            <input type="text" name="datefin" id="datefin2"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table2.draw();"
                                                                   placeholder="à"></td>

                                                        <td style="padding-left: 5px;text-align: center;"><label
                                                                    for="date"
                                                                    style="margin: 5px 20px 0 40px;">
                                                                Zone </label></td>
                                                        <td><select name="zone" id="zone2"
                                                                    class="form-control form-control-inline  select"
                                                                    onchange="table2.draw();">
                                                                <option value="">Tous</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer(2)"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>


                                            <table class="table table-striped table-bordered table-hover"
                                                   id="rapport_table2">
                                                <thead>
                                                <th width="15%">Catégorie</th>
                                                <th width="15%">Sous-catégorie</th>
                                                <th width="30%" style="text-align: center">Description</th>
                                                <th width="25%" style="text-align: center">B.Merch</th>
                                                <th width="15%" style="text-align: center">Anomalies</th>
                                                <th width="10%" style="text-align: center">Action</th>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_15_3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="myform3" style="margin-bottom: 30px;">
                                                <table id="mytable3" style="margin:auto;">
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
                                                                                                       id="date3"
                                                                                                       class="form-control form-control-inline  date-picker"
                                                                                                       onchange="table3.draw();document.getElementById('datefin3').value=this.value;"
                                                                                                       placeholder="De">
                                                            <input type="text" name="datefin" id="datefin3"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table3.draw();"
                                                                   placeholder="à"></td>

                                                        <td style="padding-left: 5px;text-align: center;"><label
                                                                    for="date"
                                                                    style="margin: 5px 20px 0 40px;">
                                                                Zone </label></td>
                                                        <td><select name="zone" id="zone3"
                                                                    class="form-control form-control-inline  select"
                                                                    onchange="table3.draw();">
                                                                <option value="">Tous</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer(3)"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>


                                            <table class="table table-striped table-bordered table-hover"
                                                   id="rapport_table3">
                                                <thead>
                                                <th width="15%">Catégorie</th>
                                                <th width="15%">Sous-catégorie</th>
                                                <th width="30%" style="text-align: center">Description</th>
                                                <th width="25%" style="text-align: center">B.Merch</th>
                                                <th width="15%" style="text-align: center">Anomalies</th>
                                                <th width="10%" style="text-align: center">Action</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_15_4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="myform4" style="margin-bottom: 30px;">
                                                <table id="mytable4" style="margin:auto;">
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
                                                                                                       id="date4"
                                                                                                       class="form-control form-control-inline  date-picker"
                                                                                                       onchange="table4.draw();document.getElementById('datefin4').value=this.value;"
                                                                                                       placeholder="De">
                                                            <input type="text" name="datefin" id="datefin4"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table4.draw();"
                                                                   placeholder="à"></td>

                                                        <td style="padding-left: 5px;text-align: center;"><label
                                                                    for="date"
                                                                    style="margin: 5px 20px 0 40px;">
                                                                Zone </label></td>
                                                        <td><select name="zone" id="zone4"
                                                                    class="form-control form-control-inline  select"
                                                                    onchange="table4.draw();">
                                                                <option value="">Tous</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer(4)"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>


                                            <table class="table table-striped table-bordered table-hover"
                                                   id="rapport_table4">
                                                <thead>
                                                <th width="15%">Catégorie</th>
                                                <th width="15%">Sous-catégorie</th>
                                                <th width="30%" style="text-align: center">Description</th>
                                                <th width="25%" style="text-align: center">B.Merch</th>
                                                <th width="15%" style="text-align: center">Anomalies</th>
                                                <th width="10%" style="text-align: center">Action</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tab_15_5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form id="myform5" style="margin-bottom: 30px;">
                                                <table id="mytable5" style="margin:auto;">
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
                                                                   name="date"
                                                                   id="date5"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table5.draw();document.getElementById('datefin5').value=this.value;"
                                                                   placeholder="De">
                                                            <input type="text" name="datefin" id="datefin5"
                                                                   class="form-control form-control-inline  date-picker"
                                                                   onchange="table5.draw();"
                                                                   placeholder="à"></td>
                                                        <td style="padding-left: 5px;text-align: center;"><label
                                                                    for="date"
                                                                    style="margin: 5px 20px 0 40px;">
                                                                Zone </label></td>
                                                        <td><select name="zone" id="zone5"
                                                                    class="form-control form-control-inline  select"
                                                                    onchange="table5.draw();">
                                                                <option value="">Tous</option>
                                                                @foreach($zones as $zone)
                                                                    <option value="{{ $zone->value }}">{{ $zone->value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="padding-left: 5px;text-align: center;">
                                                            <button class="btn dark" onclick="netoyer(5)"
                                                                    id="btn-reset">
                                                                Annuler
                                                            </button>
                                                        </td>

                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </form>


                                            <table class="table table-striped table-bordered table-hover"
                                                   id="rapport_table5">
                                                <thead>
                                                <th width="15%">Catégorie</th>
                                                <th width="15%">Sous-catégorie</th>
                                                <th width="30%" style="text-align: center">Description</th>
                                                <th width="25%" style="text-align: center">B.Merch</th>
                                                <th width="15%" style="text-align: center">Anomalies</th>
                                                <th width="10%" style="text-align: center">Action</th>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>


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


        document.getElementById('datefin1').value = today;
        document.getElementById('datefin2').value = today;
        document.getElementById('datefin3').value = today;
        document.getElementById('datefin4').value = today;
        document.getElementById('datefin5').value = today;
        document.getElementById('date1').value = past;
        document.getElementById('date2').value = past;
        document.getElementById('date3').value = past;
        document.getElementById('date4').value = past;
        document.getElementById('date5').value = past;
        $('.tab-pane').addClass('active');
        $('.select').chosen();
        $('.tab-pane').removeClass('active');
        $('#tab_15_1').addClass('active');
    </script>

    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>

    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <script>
        $.fn.dataTable.ext.errMode = 'throw';
        var table1 = $('#rapport_table1').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.checklists', array('type'=>'boutique')) }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.zone = document.getElementById('zone1').value;
                    d.datedebut = document.getElementById('date1').value;
                    d.datefin = document.getElementById('datefin1').value;
                }
            },
            responsive: true
        });

        var table2 = $('#rapport_table2').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.checklists', array('type'=>'franchise')) }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.zone = document.getElementById('zone2').value;
                    d.datedebut = document.getElementById('date2').value;
                    d.datefin = document.getElementById('datefin2').value;
                }
            },
            responsive: true
        });

        var table3 = $('#rapport_table3').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.checklists', array('type'=>'pdvc')) }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.zone = document.getElementById('zone3').value;
                    d.datedebut = document.getElementById('date3').value;
                    d.datefin = document.getElementById('datefin3').value;
                }
            },
            responsive: true
        });

        var table4 = $('#rapport_table4').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.checklists', array('type'=>'pdvl')) }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.zone = document.getElementById('zone4').value;
                    d.datedebut = document.getElementById('date4').value;
                    d.datefin = document.getElementById('datefin4').value;
                }
            },
            responsive: true
        });

        var table5 = $('#rapport_table5').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url': "{{ route('paginate.checklists', array('type'=>'smart')) }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.zone = document.getElementById('zone5').value;
                    d.datedebut = document.getElementById('date5').value;
                    d.datefin = document.getElementById('datefin5').value;
                }
            },
            responsive: true
        });

        function netoyer(id) {
            var form = "myform" + id;
            document.getElementById(form).reset();
            $.fn.dataTable.ext.search.push(
                    function (settings, data, dataIndex) {


                        return true;
                    }
            );

            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function (settings, data, dataIndex) {

                return true;

            }));
            var table = "table" + id;
            table.draw();

        }

        $(document).on('ready', function () {
            $(document).on('click', '#send_message', function () {
                var visit_id = $(this).data('id');
                $("#visit_id").val(visit_id);
            });
        });
    </script>

@endsection

@section('after-scripts-end')
@endsection