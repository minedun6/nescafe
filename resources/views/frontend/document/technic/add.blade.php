@extends('frontend.layouts.master')
@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') ?>"
          rel="stylesheet" type="text/css">
@endsection
@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>Le fichier est obligatoire !!</p>
        @endforeach
    @endif
    <div class="portlet box dark">
        <div class="portlet-title">

            <div class="caption">
                Ajouter une fiche technique
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('/technic_file/add') }}" method="post" enctype="multipart/form-data" id="document_form">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cible</label>
                            <select class="form-control" name="cible">
                                <option value="VD">VD</option>
                                <option value="VI">VI</option>
                                <option value="VDI">VDI</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Fichier</label>
                            <div class="col-md-12" style="padding-left: 0px">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="input-group input-large">
                                        <div class="form-control uneditable-input input-fixed "
                                             data-trigger="fileinput">
                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                            <span class="fileinput-filename"> </span>
                                        </div>
                                                            <span class="input-group-addon btn default btn-file">
                                                                <span class="fileinput-new"> Parcourir </span>
                                                                <span class="fileinput-exists"> Changer </span>
                                                                <input type="file" name="fiche"> </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput"> Annuler </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Réseau</label>
                            <select class="form-control" name="network">
                                @foreach($network_types as $network_type)
                                    <option value="{!! $network_type->code !!}">{!! $network_type->value !!}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catégorie</label>
                            <input class="form-control" name="cat">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sous-catégorie</label>
                            <input class="form-control" name="scat">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 20px;">

                    <button class="btn dark" type="submit" style="float: right; margin-right: 15px;">
                        Valider
                    </button>
                </div>

            </form>

        </div>

    </div>
@endsection
@section('footer')
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')?>"
            type="text/javascript"></script>
@endsection