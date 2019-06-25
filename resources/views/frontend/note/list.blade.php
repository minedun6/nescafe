@extends('frontend.layouts.master')

@section('second-title')
    | LISTE DES NOTES DE SERVICE
@stop

@section('url-way')
    <li>
        <a href="{{url('/service/note')}}">Notes de service</a>
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
                        <span class="caption-subject bold uppercase">Liste des notes de service</span>
                    </div>
                    <div class="actions">
                        @roles('Merch', 'Visiteur')
                        @else
                        <a href="{{ url('/service/note/add') }}" class="btn btn-sm dark"><i
                                    class="fa fa-plus"></i> Ajouter une note</a>
                        @endauth
                    </div>

                </div>
                <div class="portlet-body">

                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <th width="15%">Date</th>
                            <th width="20%">Expediteur</th>
                            <th width="35%">Objet</th>
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
                'url': "{{ url('/service/notes/') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                }
            },
            responsive: true,
            "columnDefs": [
                {
                    "targets": [3],
                    "className": 'dt-body-center'
                }
            ]
        });
    </script>

@endsection