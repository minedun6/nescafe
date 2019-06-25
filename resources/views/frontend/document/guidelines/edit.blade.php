@extends('frontend.layouts.master')
@section('second-title')
    | Modifcation guideline
@stop
@section('url-way')
    <li>
        <a href="#">Gestion des documents</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/guideline')}}">Guidelines</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Modifier un guideline</a>
    </li>
@stop

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
                Modifier un guideline
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('/guideline/edit/'.$guide_line->id) }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" class="form-control" name="name"
                                   value="{{ $guide_line->nom ? $guide_line->nom : '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cible</label>
                            <select class="form-control" name="weeks">
                                <option value="VD" {{ $guide_line->cible = 'VD' ? 'selected' : '' }}>VD</option>
                                <option value="VI" {{ $guide_line->cible = 'VI' ? 'selected' : '' }}>VI</option>
                                <option value="VDI" {{ $guide_line->cible = 'VDI' ? 'selected' : '' }}>VDI</option>

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
                                                                <input type="file" name="guideline"> </span>
                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists"
                                           data-dismiss="fileinput"> Annuler </a>
                                    </div>
                                </div>
                            </div>
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