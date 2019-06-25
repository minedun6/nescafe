@extends('frontend.layouts.master')
@section('second-title')
    | Confirmer suppression note de service
@stop

@section('url-way')
    <li>
        <a href="{{url('/service/note')}}">Notes de service</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Confirmer suppression note de service</a>
    </li>
@stop

@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Suppression Note Service
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body">
            <span>
                Vous êtes sure de vouloir supprimer la note: <br/>
                {!! strip_tags($note->message) !!}
            </span>
            <div>
                <a class="btn btn-sm dark" id="btn-detail"
                   href="{{ url("/service/note/destroy/" . $note->id)}}"><i
                            class="fa fa-info"></i> Confirmer</a>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection