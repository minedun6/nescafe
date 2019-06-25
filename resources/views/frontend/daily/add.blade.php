@extends('frontend.layouts.master')

@section('second-title')
    | Ajouter une réponse
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visits/daily')}}">Visites quotidiennes</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $visit->visit_date->format('d/m/Y') }}</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Ajouter une réponse</a>
    </li>
@stop

@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ?>"
          rel="stylesheet" type="text/css">
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/icheck/skins/all.css') ?>"
          rel="stylesheet" type="text/css">
@endsection
@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>Vous devez Vérifier les types des images !!</p>
        @endforeach
    @endif
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Réponse visite quotidienne</span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : {{ $visit->visit_date->format('d/m/Y') }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : {{ $visit->network->code }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : {{ $visit->network->name }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : {{ $visit->network->pdv ? $visit->network->pdv->category : $visit->network->type->value }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser : {{ $visit->user->name }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Zone
                                        : {{ $visit->network ? $visit->network->city->zone->value : '' }}</b></label></br>
                                <label class="control-label"></label>
                            </div>
                        </div>
                    </div>
                    <form action="{{ url('answers/add/'.$visit->id) }}" method="post" files="true"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 10%;"> Catégorie</th>
                                <th style=" color: #F2784B; width: 20%;"> Sous-catégorie</th>
                                <th style=" color: #F2784B; width: 40%;"> Description</th>
                                <th style=" color: #F2784B; text-align: center; "> Statut</th>
                                <th style=" color: #F2784B; width: 10%; text-align: center;"> Image</th>
                                <th style=" color: #F2784B; width: 10%; text-align: center;"> Commentaire</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($visit->checklist->tasks as $index => $task)
                                <tr>
                                    <td> {{ $task->taskSubCategory->taskCategory->name }}</td>
                                    <td> {{ $task->taskSubCategory->name }}</td>
                                    <td> {{ $task->description }}</td>
                                    <td style="text-align: center">
                                        <label style="color: limegreen">
                                            <input type="radio" name="radio[{{ $index }}]" value="ok" class="icheck"> OK
                                        </label>
                                        <label style="color: darkorange;padding-left: 2px;">
                                            <input type="radio" name="radio[{{ $index }}]" value="na" checked
                                                   class="icheck"> N/A
                                        </label>
                                        <label style="color: red;padding-left: 2px;">
                                            <input type="radio" name="radio[{{ $index }}]" value="ko" class="icheck"> KO
                                        </label>
                                    </td>
                                    <td style="text-align: center">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn dark btn-file">
                                                            <span class="fileinput-new"> Parcourir </span>
                                                            <input type="file" name="picture{{$index}}"> </span>
                                        </div>
                                    </td>
                                    <td style="text-align: center">
                                        <a class="btn  btn-sm dark" data-target="#remark_form_{{ $index }}"
                                           data-toggle="modal">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                        <div class="modal fade" id="remark_form_{{ $index }}" tabindex="-1" role="basic"
                                             aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        <h4 class="modal-title" style="color: #F2784B;">
                                                            Commentaire</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <textarea type="text" class="form-control"
                                                                  name="remark[{{ $index }}]" id="remark[{{ $index }}]"
                                                                  rows="2"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn dark" data-dismiss="modal"
                                                                aria-hidden="true">Envoyer
                                                        </button>

                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div>

                                        </div>

                                    </td>
                                    <td style="visibility: hidden"><input type="hidden" name="task_id[{{ $index }}]"
                                                                          value="{{ $task->id }}"></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <td colspan="2">Commentaire sur la visite</td>
                            <td colspan="4"><textarea class="form-control" rows="2" colspan="4"
                                                      name="note_on_visit"></textarea></td>
                            </tfoot>
                        </table>
                        <div class="row">
                            <button class="btn dark" type="submit"
                                    style="float: right; margin-right: 15px;">Envoyer
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/icheck/icheck.min.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>
    <script>
        $('#rapport_table').DataTable({
            "bPaginate": false,
            "bInfo": false,
            responsive: true

        });

    </script>

@endsection