@extends('frontend.layouts.master')
@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ?>"
          rel="stylesheet" type="text/css">
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-toastr/toastr.min.css') ?>" rel="stylesheet" type="text/css">
@endsection


@section('content')

    <div class="portlet box dark">


        <div class="portlet-title">

            <div class="caption">
                Mise à jour planning
            </div>
        </div>
        <div class="portlet-body">
            <form id= "generate_planning_form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">


                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date début</label>
                            <input type="text" id="date_debut" name="date_debut" class="form-control form-control-inline  date-picker"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date fin</label>
                            <input type="text" id="date_fin" name="date_fin" class="date-picker form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Première semaine</label>
                            <select class="form-control" name="week_nbr">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>

                    </div>

                </div>
                <div class="row" style="margin-top: 20px;">

                    <div class="col-md-9">Ceci est un exemple d'un <a href= " {{ url("/admin/download/planning/6") }}">fichier planning <i
                                    class="fa fa-download"></i> </a></div>
                    <button id="generate_planning_submit" class="btn dark" type="button" style="float: right; margin-right: 15px;">
                        Valider
                    </button>
                </div>

            </form>

        </div>
    </div>
	
	<div class="portlet box dark">
        <div class="portlet-title">
		   <div class="caption">
               Liste Merchandisers
            </div>
        </div>
        <div class="portlet-body">

			<table class="table table-striped table-bordered table-hover" id="merchs_table">
				<thead>
					<th width="20%">Merchandiser</th>
					<th width="20%">Date fin planning</th>
					<th width="20%">Dernière mise à jour</th>
					<th width="20%" style="text-align: center">Actions</th>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	
	
    <div class="portlet box dark">
        <div class="portlet-title">

            <div class="caption">
               Supprimer planning
            </div>
        </div>
        <div class="portlet-body">
            <form id= "delete_planning_form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">


                <div class="row">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date début</label>
                            <input type="text" id="date_debut_supp" name="date_debut" class="date-picker form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Date fin</label>
                            <input type="text" id="date_fin_supp" name="date_fin" class="date-picker form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">

                    <button id="delete_planning_submit" class="btn dark" type="button" style="float: right; margin-right: 15px;">
                        Valider
                    </button>
                </div>

            </form>

        </div>

    </div>

	
	    <div class="modal fade" id="img_reviewer" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true"></button>
                        <h4 class="modal-title" id="img_title"></h4>
                    </div>
                    <div class="modal-body"><img id="img_pop" style="display: block; width: 98%; " src=""
                                                 alt=""></div>
                    <div class="modal-footer">
                        <h5 class="modal-title" id="img_footer" style="text-align: left"></h5>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>


    <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation</h4>
                </div>
                <div class="modal-body" >
                    Vous êtes sur le point de générer un planning pour tous les merchandisers avec les pramètres suivantes: <br><br>
                    <div id="generate_planning_message">

                    </div>
                    Voulez vous confirmer ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn green" id="generate_planning_validate">Confirmer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="delete" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Validation</h4>
                </div>
                <div class="modal-body" >
                    Vous êtes sur le point de supprimer le planning de tous les merchandisers avec les pramètres suivantes: <br><br>
                    <div id="delete_planning_message">

                    </div>
                    Voulez vous confirmer ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn green" id="delete_planning_validate">Confirmer</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@section('footer')
    <script>

        $('.date-picker').datepicker();
    </script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')?>"
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-toastr/toastr.min.js')?>" type="text/javascript"></script>
    <script>
	var table = $('#merchs_table').DataTable({
            "processing": true,
            "serverSide": true,
            "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
            "iDisplayLength": 50,
            "bFilter": false,
            "bSort": false,
            "ajax": {
                'url':"{{ url('admin/paginate/planning') }}",
                'type': 'get',
                'data': function (d) {
                }
            },
            responsive: true
        });

    $('#generate_planning_submit').on('click',function (){
        $('#generate_planning_submit').attr('disabled', 'true');
        $.ajax({
            type: "POST",
            url: "{{ url('admin/pregenerate/planning') }}",
            data: $("#generate_planning_form").serialize(), // serializes the form's elements.
        }).done(function(t){
            if (t.response == 'ok') {
                $('#generate_planning_message').html('Date début: <b>'+ $('#date_debut').val() +
                        '</b><br>Date fin: <b>' + $('#date_fin').val() + '</b><br><br>' + 'Cette période contient <b>' + t.visits
                        + ' visites planifiées (' + t.visited + ' effectuées)<b/><br>'
                );
                $('#basic').modal('toggle');
            } else {
                toastr["error"](t.message, "Erreur");
            }
            setTimeout(function() {
                $('#generate_planning_submit').removeAttr('disabled');
            }, 3000);
        })
    })

    $('#generate_planning_validate').on('click',function (){
        $('#basic').modal('hide');
        $.ajax({
            type: "POST",
            url: "{{ url('admin/planning/') }}",
            data: $("#generate_planning_form").serialize(), // serializes the form's elements.
        }).done(function(t){
            if (t == 'ok') {
                toastr["success"]("Le planning a été généré avec succès");
            } else {
                toastr["error"]("Une erreur a été produite, veuillez contacter Peaksource.", "Erreur");
            }
        })
    })

    $('#delete_planning_submit').on('click',function (){
        $('#delete_planning_submit').attr('disabled', 'true');
        $.ajax({
            type: "POST",
            url: "{{ url('admin/pregenerate/planning/') }}",
            data: $("#delete_planning_form").serialize(), // serializes the form's elements.
        }).done(function(t){
            if (t.response == 'ok') {
                $('#delete_planning_message').html('Date début: <b>'+ $('#date_debut_supp').val() +
                        '</b><br>Date fin: <b>' + $('#date_fin_supp').val() + '</b><br><br>' + 'Cette période contient <b>' + t.visits
                        + ' visites planifiées (' + t.visited + ' effectuées)<b/><br>'
                );
                $('#delete').modal('toggle');
            } else {
                toastr["error"](t.message, "Erreur");
            }
            setTimeout(function() {
                $('#delete_planning_submit').removeAttr('disabled');
            }, 3000);
        })
    })

    $('#delete_planning_validate').on('click',function (){
        $('#delete').modal('hide');
        $.ajax({
            type: "POST",
            url: "{{ url('admin/delete/planning/') }}",
            data: $("#delete_planning_form").serialize(), // serializes the form's elements.
        }).done(function(t){
            if (t == 'ok') {
                toastr["success"]("Le planning a été supprimé avec succès");
            } else {
                toastr["error"]("Une erreur a été produite, veuillez contacter Peaksource.", "Erreur");
            }
        })
    })
	</script>
@endsection