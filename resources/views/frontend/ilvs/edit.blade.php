@extends('frontend.layouts.master')

@section('second-title')
    | ILV {{ $ilv->name }}
@stop
@section('url-way')
    <li>
        <a href="{{url('/ilv')}}">ILV</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $ilv->name }}</a>
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
            <p>{{ $error }}</p>
        @endforeach
    @endif
    <div class="portlet box dark">
        <div class="portlet-title">
            <div class="caption">
                Editer un ILV
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('/ilv/edit/'.$ilv->id) }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">

                            <label>Nom</label>
                            <input class="form-control" value="{{ $ilv->name }}" name="name" type="text">
                        </div>
                        <div class="form-group">
                            <label>Type de réseau</label>
                            <select class="form-control" name="network_type" id="network_type">
                                <option value=""></option>
                                @foreach($network_types as $network_type)
                                    @if($ilv->network_type_id == $network_type->id)
                                        <option selected
                                                value="{{ $network_type->id }}">{{ $network_type->value }}</option>
                                    @else
                                        <option value="{{ $network_type->id }}">{{ $network_type->value }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Cible</label>
                            <select class="form-control" name="target" id="target">
                                <option value=""></option>
                                <option {{ $ilv->target == 'VD' ? 'selected' : '' }} value="VD">VD</option>
                                <option {{ $ilv->target == 'VI' ? 'selected' : '' }} value="VI">VI</option>
                                <option {{ $ilv->target == 'VDI' ? 'selected' : '' }} value="VDI">VDI</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input class="form-control" name="should_notify"
                                   {{ $ilv->should_notify ? 'checked' : '' }} type="checkbox">Notifier en cas de
                            rupture?</input>
                        </div>
                        <div class="form-group">
                            <label>Fichier : </label>
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn dark btn-file">
                                                            <span class="fileinput-new"> Parcourir </span>
                                                            <input type="file" name="picture"> </span>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <button class="btn dark" type="submit"
                                    style="float: right; margin-right: 15px;">
                                Valider
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('footer')
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')?> "
            type="text/javascript"></script>
    <script>
        $('#target').on('change', function () {
            if ($('#target').prop('selectedIndex') != 0) {
                console.log($('#target').prop('selectedIndex'));
                $('#network_type').prop('selectedIndex', 0);

            }
        });
        $('#network_type').on('change', function () {
            if ($('#network_type').prop('selectedIndex') != 0) {
                console.log($('#network_type').prop('selectedIndex'));
                $('#target').prop('selectedIndex', 0);

            }
        })

    </script>
@endsection