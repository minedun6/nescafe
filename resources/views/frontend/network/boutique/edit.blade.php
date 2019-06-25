@extends('frontend.layouts.master')

@section('second-title')
    | Modifier Boutique 
@stop
@section('url-way')
    <li>
        <a href="#">Réseaux</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/network/list/boutique')}}">Boutiques</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Modifier Boutique</a>
    </li>
@stop


@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="portlet box dark">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-"></i>Editer une boutique
                    </div>
                    <div class="tools">

                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('/network/edit/boutique/'.$network->id) }}" method="post">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label">Code</label>
                                <input type="text" class="form-control" value="{{ $network->code }}" name="code"
                                       placeholder="Code">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nom</label>
                                <input type="text" class="form-control" value="{{ $network->name }}" name="name"
                                       placeholder="Nom">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Responsable</label>
                                <div class="input-icon right">
                                    <i class="fa fa-user"></i>
                                    <input type="text" class="form-control" value="{{ $network->responsible }}"
                                           name="responsible"
                                           placeholder="Responsable"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone</label>
                                <div class="input-icon right">
                                    <i class="fa fa-mobile-phone"></i>
                                    <input type="text" class="form-control" value="{{ $network->phone }}" name="phone1"
                                           placeholder="Tel"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone 2</label>
                                <div class="input-icon right">
                                    <i class="fa fa-mobile-phone"></i>
                                    <input type="text" class="form-control" value="{{ $network->phone2 }}" name="phone2"
                                           placeholder="Tel2"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone fixe</label>
                                <div class="input-icon right">
                                    <i class="fa fa-phone-square"></i>
                                    <input type="text" name="land_line" value="{{ $network->land_line }}"
                                           class="form-control" placeholder="Tel fixe">
                                </div>
                            </div>
                            <div class="form-group ui-widget">
                                <label class="control-label">Ville</label>
                                <input type="text" class="form-control"
                                       value="{{ $network->city ? $network->city->name : '' }}" placeholder="Ville"
                                       id="town"
                                       name="town">
                                <input type="hidden" id="city_id" name="city_id"
                                       value="{{ $network->city ? $network->city->id : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Code Postal</label>
                                <input type="text" class="form-control" value="{{ $network->postal_code }}"
                                       placeholder="Code Postal" id="town"
                                       name="postal_code">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Adresse</label>
                                <div class="input-icon right">
                                    <i class="fa fa-road"></i>
                                    <input type="text" name="address" value="{!! strip_tags($network->address) !!}"
                                           class="form-control" placeholder="adresse"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Smart ?</label>
                                <label>
                                    <input class="form-control"
                                           value="true"
                                           {{ $network->type ? ($network->type->code == 'smart' ? 'checked' : '') :'' }}
                                           type="radio" name="smart" id="smart">
                                    Oui
                                </label>
                                <label>
                                    <input class="form-control"
                                           value="false"
                                           {{ $network->type ? ($network->type->code != 'smart' ? 'checked' : '') :'' }}
                                           type="radio" name="smart" id="smart">
                                    Non
                                </label>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn dark">valider</button>
                            <button type="button" class="btn default">Annuler</button>
                        </div>
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"/>
    <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script>
        $('#town').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{ url('/city/find/') }}",
                    dataType: "json",
                    type: 'post',
                    data: {
                        'name': $("#town").val(),
                        '_token': "{!! csrf_token() !!}"
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 3,
            change: function (event, ui) {
                if (ui.item == null || ui.item == undefined) {
                    $("#town").val("");
                    $("#town").attr("disabled", false);
                } else {
                    $("#city_id").val(ui.item.id);
                }
            },
            select: function (event, ui) {
                $("#city_id").val(ui.item.id);
            }
        });
    </script>
@endsection