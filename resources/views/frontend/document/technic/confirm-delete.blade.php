@extends('frontend.layouts.master')
@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Suppression fiche technique
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body">
            <span>
                Vous êtes sure de vouloir supprimer la fiche {{ $technic_file->nom }}
            </span>
            <div>
                <a class="btn btn-sm dark" id="btn-detail"
                   href="{{ url("/technic_file/destroy/" . $technic_file->id)}}"><i
                            class="fa fa-info"></i> Confirmer</a>
            </div>
        </div>
    </div>
@endsection
@section('footer')
@endsection