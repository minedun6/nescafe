@extends('frontend.layouts.master')
@section('second-title')
    | Modification note de service
@stop

@section('url-way')
    <li>
        <a href="{{url('/service/note')}}">Notes de service</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Modification note de service</a>
    </li>
@stop

@section('header')
@endsection
@section('content')
    <div class="portlet box dark">
        <div class="portlet-title">
            <div class="caption">
                Editer la note de service
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('/service/note/edit/'.$note->id) }}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">

                            <label>Objet</label>
                            <input class="form-control" name="object" value="{!! $note->object !!}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group">
                            <label>Note</label>
                            <textarea class="form-control" name="note"
                                      rows="5">{!! strip_tags($note->message) !!}</textarea>
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

@endsection