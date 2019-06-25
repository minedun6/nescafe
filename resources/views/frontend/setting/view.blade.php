@extends('frontend.layouts.master')
@section('second-title')
    | Paramètres globaux
@stop
@section('url-way')
    <li>
        <a href="#">Paramètres</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/setting')}}">Paramètres globaux</a>
    </li>
@stop

@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-settings"></i>Paramètres
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body">
<form > <div class="row">

        <div class="form-group">
            <div class="col-md-3">
                <label class="control-label"><b> Notifier par email
                        : </b></label>
            </div>
            <div class="col-md-9">
                <input type="checkbox" class="make-switch" checked data-on-color="success" data-off-color="danger" data-size="small">
            </div>
        </div>


    </div>
    <div class="row">
        <button class="btn btn-small dark" type="submit" style="float: right;margin-right: 3%">Valider</button>
    </div>
</form>

        </div>

    </div>



@endsection