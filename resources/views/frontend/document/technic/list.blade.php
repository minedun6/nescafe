@extends('frontend.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Liste des fiches technique</span>
                    </div>
                    <div class="actions">
                        @roles('Merch', 'Visiteur')
                        @else
                        <a href="{{ url('/technic_file/add') }}" class="btn btn-sm dark"><i
                                    class="fa fa-plus"></i>Ajouter une fiche technique</a>
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
                                    <td width="8%" style="text-align: center;"><label for="date" style="margin-top: 5px;"> Nom </label></td>
                                    <td width="12%" style="padding-left:5px;" id="row2"><input type="text"
                                                                                               style="margin-bottom: 3px;"
                                                                                               name="name" id="name"
                                                                                               class="form-control form-control-inline  date-picker"
                                                                                               oninput="table.draw();"
                                                                                               placeholder="">
                                    </td>

                                    <td width="8%" style="padding-left: 5px;text-align: center;"><label style="margin-top: 5px;" for="date">Réseaux </label></td>
                                    <td width="12%"><select type="text" name="network" id="network" onchange="table.draw();" class="form-control form-control-inline  ">
                                            <option></option>
                                            @foreach($network_types as $network_type)
                                                <option value="{!! $network_type->code !!}">{!! $network_type->value !!}</option>
                                            @endforeach
                                        </select></td>
                                    <td width="8%" style="text-align: center;"><label for="date" style="margin-top: 5px;"> Catégorie </label></td>
                                    <td width="12%" style="padding-left:5px;" id=""><input type="text"
                                                                                           style="margin-bottom: 3px;"
                                                                                           name="cat" id="cat"
                                                                                           class="form-control form-control-inline  date-picker"
                                                                                           oninput="table.draw();"
                                                                                           placeholder="">
                                    </td>
                                    <td width="8%" style="text-align: center;"><label for="date" style="margin-top: 5px;"> Sous-catégorie </label></td>
                                    <td width="12%" style="padding-left:5px;" id="row2"><input type="text"
                                                                                               style="margin-bottom: 3px;"
                                                                                               name="scat" id="scat"
                                                                                               class="form-control form-control-inline  date-picker"
                                                                                               oninput="table.draw();"
                                                                                               placeholder="">
                                    </td>
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
                            <!-- <th>Dernier visite</th>-->
                            <th width="8%">Date</th>
                            <th width="20%">Nom</th>
                            <th width="5%">Cible</th>
                            <th width="10%">Réseau</th>
                            <th width="10%">Catégorie</th>
                            <th width="7%">Sous-catégorie</th>
                            <th width="10%" style="text-align: center">Nbr lectures</th>
                            <th width="30%" style="text-align: center">Actions</th>
                            </thead>
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
                'url': "{{ url('/technic_files/paginate') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.name = document.getElementById('name').value;
                    d.network = document.getElementById('network').value;
                    d.cat = document.getElementById('cat').value;
                    d.scat = document.getElementById('scat').value;
                }
            },
            responsive: true,
            "columnDefs": [

                {
                    "targets": [7],
                    "className": 'dt-body-center'
                },
                {
                    "targets": [6],
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