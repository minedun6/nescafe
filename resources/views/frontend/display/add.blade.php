@extends('frontend.layouts.master')

@section('second-title')
    | Ajouter une visite
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visits/display')}}">Visites Display</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Ajouter une visite</a>
    </li>
@stop


@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/fileinput/fileinput.css') ?>"
          rel="stylesheet" type="text/css">
@endsection
@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>Vous devez Vérifier les types des images !!</p>
        @endforeach
    @endif
    <div class="portlet box dark">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Ajouter visite display
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
                                : {{ $visit->network->type->value }}</b></label></br>
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
            <div class="panel-group accordion" id="accordion3">
                <form action="{{ url('photos/add/display/'.$visit->id) }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">

                    @foreach($categories as $index => $category)

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse"
                                       data-parent="#accordion{{ $index }}" href="#collapse{{ $index }}"
                                       aria-expanded="false">
                                        {{ $category->value }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{ $index }}" class="panel-collapse collapse" aria-expanded="false"
                                 style="height: 0px;">
                                <div class="panel-body" class="form-horizontal form-bordered">
                                    <div class="form-body">
                                        <div class="form-group last">
                                            <div class="col-md-9">
                                                <input type="file" multiple name="{{ $category->code }}vitrine[]"
                                                       class="file"
                                                       onchange="counting(this,'{{ $index }}', '{{ $category->code }}')">
                                                <input type="hidden" name="category_id[]"
                                                       value="{{ $category->id }}">
                                            </div>

                                            <div class="col-md-3" id="extra_inputs_{{ $index }}">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-actions">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="row" style="margin-top: 20px;">
                        <button class="btn dark" type="submit" style="float: right; margin-right: 15px;">
                            Valider
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        $(".file").fileinput({'showUpload': false, 'previewFileType': 'any', 'language': 'fr'});
    </script>
    <script>

        function counting(x, j, code) {
            file = x.files.length;

            document.getElementById('extra_inputs_' + j).innerHTML = "";
            for (i = 0; i < file; i++) {
                var div = document.createElement('div');

                div.className = 'row';

                div.innerHTML = "<label style='color: #9A12B3' >Commentaire pour " + x.files[i].name + "</label>" +
                        "<input type='text' class='form-control' name= '" + code + "commentaire[" + i + "]'> ";

                document.getElementById('extra_inputs_' + j).appendChild(div);
            }
        }
    </script>
@endsection