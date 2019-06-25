@extends('frontend.layouts.master')
@section('second-title')
    | Gestion des tâches
@stop
@section('url-way')
    <li>
        <a href="#">Paramètres</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/tasks')}}">Gestion des tâches</a>
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
                        <span class="caption-subject bold uppercase">Liste des tâches </span>
                    </div>
                    <div class="actions">
                        <a href="{{ url('/tasks/add') }}" class="btn btn-sm dark"><i
                                    class="fa fa-plus"></i> Ajouter une tâche</a>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="row">
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <th width="15%">Catégorie</th>
                            <th width="15%">Sous-catégorie</th>
                            <th width="40%" style="text-align: center">Description</th>
                            <th width="15%">Checklist</th>
                            <th width="25%" style="text-align: center">Actions</th>
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
                'url': "{{ url('/tasks/paginate') }}",
                'type': 'get',
                'data': function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1;
                }
            },
            responsive: true
        });
    </script>

@endsection