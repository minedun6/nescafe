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
        <a href="{{url('/visits/ilv')}}">Visites ILV</a>
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
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Réponse visite ILV</span>
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">
                                    {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '' }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->code : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->name : ''}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network->type->value }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser : </b></label></br>
                                <label class="control-label">{{ $visit->user->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Zone
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->city->zone->value : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <form id="ilv_form" action="{{ url('visits/ilv/add/'.$visit->id) }}" method="post" files="true"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                        <table class="table table-striped table-bordered table-hover" id="rapport_table">
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 60%;text-align: center"> Nom</th>
                                <th style="color: #F2784B; width: 20%;text-align: center"> Photo</th>
                                <th style=" color: #F2784B; width: 20%;text-align: center"> Etat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ilvs as $index => $ilv)
                                <tr>
                                    <td>
                                        {{ $ilv->name }}
                                        <input type="hidden" name="ilv_id[]" value="{{ $ilv->id }}">
                                    </td>
                                    <td>
                                        <a class="btn dark" data-toggle="modal" data-target="#img_reviewer"
                                           onclick='set_link("{{ url($ilv->photo->path) }}") '><i
                                                    class="fa fa-search"></i> Aperçu </a>
                                    </td>
                                    <td style="text-align: center;">
                                        <label style="color: limegreen;" class="response-btn">
                                            <input type="radio" name="radio[{{ $ilv->id }}]" value="true"
                                                   class="icheck"/>
                                            Disponible
                                        </label>
                                        <label style="color: red;padding-left: 2px;" class="response-btn">
                                            <input type="radio" name="radio[{{ $ilv->id }}]" value="false"
                                                   class="icheck"/>
                                            En
                                            rupture
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
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
            responsive: true,
            "columnDefs": [
                {
                    "targets": [1],
                    "className": 'dt-body-center'
                }
            ]
        });
    </script>
    <script>
        function set_link(link) {
            if (decodeURIComponent(link) != "") {
                document.getElementById("img_pop").setAttribute("src", decodeURIComponent(link));
            }
            else {
                return false;
            }
        }
    </script>
@endsection