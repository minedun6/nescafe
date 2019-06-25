@extends('frontend.layouts.master')
@section('second-title')
    | Confirmer suppression guideline
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
        <a href="#">Suppression guideline</a>
    </li>
@stop

@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Suppression Guideline
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body">
            <span>
                Vous êtes sure de vouloir supprimer le Guideline {{ $guide_line->nom }}
            </span>
            <div>
                <a class="btn btn-sm dark" id="btn-detail"
                   href="{{ url("/guideline/destroy/" . $guide_line->id)}}"><i
                            class="fa fa-info"></i> Confirmer</a>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection