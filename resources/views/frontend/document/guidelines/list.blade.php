@extends('frontend.layouts.master')
@section('second-title')
    | Guidelines
@stop
@section('url-way')
    <li>
        <a href="#">Gestion des documents</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/guideline')}}">Guidelines</a>
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
                        <span class="caption-subject bold uppercase">Liste des guidelines</span>
                    </div>
                    <div class="actions">
                        @roles('Merch', 'Visiteur')
                        @else
                            <a href="{{ url('/guideline/add') }}" class="btn btn-sm dark"><i
                                        class="fa fa-plus"></i>Ajouter un guideline</a>
                            @endauth
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row">
                        <form id="myform">
                            <table id="mytable" style="width: 100%">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td width="20%" style="text-align: center;"><label for="date"
                                                                                       style="margin-top: 5px;">
                                            Nom </label></td>
                                    <td width="20%" style="padding-left:5px;" id="row2"><input type="text"
                                                                                               style="margin-bottom: 3px;"
                                                                                               name="name" id="name"
                                                                                               class="form-control form-control-inline  date-picker"
                                                                                               oninput="table.draw();"
                                                                                               placeholder="">
                                    </td>

                                    <td width="20%" style="padding-left: 5px;text-align: center;"><label
                                                style="margin-top: 5px;" for="cible">Cible </label></td>
                                    <td width="20%"><select type="text" name="cible" id="cible" onchange="table.draw();"
                                                            class="form-control form-control-inline  ">
                                            <option value=""></option>
                                            <option value="VD">VD</option>
                                            <option value="VI">VI</option>
                                            <option value="VDI">VDI</option>

                                        </select></td>

                                    <td width="20%" style="padding-left: 5px;text-align: center;">
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
                            <th width="10%">Date</th>
                            <th width="40%">Nom</th>
                            <th width="10%">Cible</th>
                            <th width="10%">Nbr des lectures</th>
                            <th width="30%" style="text-align: center">Actions</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer')
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
                'url': "{{ url('/guidelines/paginate') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.name = document.getElementById('name').value;
                    d.cible = document.getElementById('cible').value;
                }
            },
            responsive: true,
            "columnDefs": [

                {
                    "targets": [4],
                    "className": 'dt-body-center'
                }
            ]
        });
    </script>

    <script>
        function netoyer() {
            // document.getElementById("myform").reset();
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