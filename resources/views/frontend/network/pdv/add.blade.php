@extends('frontend.layouts.master')

@section('second-title')
    | Ajouter Point de vente 
@stop
@section('url-way')
    <li>
        <a href="#">Réseaux</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/network/list/pdv')}}">Point de vente</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Ajouter Point de vente </a>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="portlet box dark">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-"></i>Ajouter un point de vente
                    </div>
                    <div class="tools">
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    <form action="{{ url('/network/add/pdv') }}" method="post" id="network_form">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label">Code</label>
                                <input type="text" class="form-control" name="code" placeholder="Code">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nom</label>
                                <input type="text" name="name" class="form-control" placeholder="Nom" >
                            </div>
                            <div class="form-group">
                                <label class="control-label">Responsable</label>
                                <div class="input-icon right">
                                    <i class="fa fa-user"></i>
                                    <input type="text" name="responsible" class="form-control"
                                           placeholder="Responsable"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Secteur</label>
                                <input type="text" class="form-control" name="sector" placeholder="Secteur">
                            </div>
                            <div class="form-group">
                                <label class="control-label">CDS</label>
                                <input type="text" class="form-control" name="cds" placeholder="CDS">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Catégorie</label>
                                <select name="type_id" class="form-control" >
                                    @foreach($network_types as $network_type)
                                        <option value="{{ $network_type->id }}">{{ $network_type->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone</label>
                                <div class="input-icon right">
                                    <i class="fa fa-mobile-phone"></i>
                                    <input type="text" name="phone1" class="form-control" placeholder="Tel"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone 2</label>
                                <div class="input-icon right">
                                    <i class="fa fa-mobile-phone"></i>
                                    <input type="text" class="form-control" name="phone2" placeholder="Tel2"></div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Téléphone fixe</label>
                                <div class="input-icon right">
                                    <i class="fa fa-phone-square"></i>
                                    <input type="text" class="form-control" name="land_line" placeholder="Tel fixe">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Ville</label>
                                <input type="text" class="form-control" placeholder="Ville" id="town" name="town">
                                <input type="hidden" id="city_id" name="city_id" value="">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Code Postal</label>
                                <input type="text" class="form-control" placeholder="Code Postal" id="codep"
                                       name="postal_code">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Adresse</label>
                                <div class="input-icon right">
                                    <i class="fa fa-road"></i>
                                    <input type="text" name="address" class="form-control" placeholder="adresse"></div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn dark">Ajouter</button>
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