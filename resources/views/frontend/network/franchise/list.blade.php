@extends('frontend.layouts.master')

@section('second-title')
    | Franchises
@stop
@section('url-way')
    <li>
        <a href="#">Réseaux</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/network/list/franchise')}}">Franchises</a>
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
                        <span class="caption-subject bold uppercase">Liste des franchises </span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('/network/add/franchise') }}" class="btn btn-sm dark"><i
                                    class="fa fa-plus"></i>Ajouter une franchise</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row" style="padding-bottom: 20px">


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

                                </tr>
                                </thead>
                                <tbody>
                                <tr>

                                    <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                             style="margin-top: 5px;">
                                            Nom </label></td>
                                    <td width="15%"><input type="text" name="network" id="network"
                                                           class="form-control form-control-inline  "
                                                           oninput="table.draw()"></td>
                                    <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                             style="margin-top: 5px;">
                                            Ville </label></td>
                                    <td width="15%"><input type="text" name="city" id="city"
                                                           class="form-control form-control-inline  "
                                                           oninput="table.draw()"></td>
                                    <td style="padding-left: 5px;text-align: center;"><label for="date"
                                                                                             style="margin-top: 5px;">
                                            Gouvernerat </label></td>
                                    <td width="15%"><input type="text" name="governorate" id="governorate"
                                                           class="form-control form-control-inline  "
                                                           oninput="table.draw()"></td>
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
                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <th>Dernière visite</th>
                            <th>Code</th>
                            <th>Nom</th>
                            <th>Responsable</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Gouvernerat</th>
                            <th>Actions</th>
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
                'url': "{{ url('/network/paginate/franchise') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                    d.network = document.getElementById('network').value;
                    d.city = document.getElementById('city').value;
                    d.governorate = document.getElementById('governorate').value;
                }
            },
            responsive: true
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