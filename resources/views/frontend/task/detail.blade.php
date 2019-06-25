@extends('frontend.layouts.master')

@section('second-title')
    | Détail d'une tâche
@stop
@section('url-way')
    <li>
        <a href="#">Paramètres</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/tasks')}}">Gestion des tâches</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Détail une tâche</a>
    </li>
@stop


@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Détail de tâche
            </div>
            <div class="tools">
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"><b>Catégorie
                                : </b></label></br>
                        <label class="control-label"> {{ $task->taskSubCategory ? ($task->taskSubCategory->taskCategory ? $task->taskSubCategory->taskCategory->name : '') : '' }}</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"><b>Sous catégorie
                                : </b></label></br>
                        <label class="control-label">{{  $task->taskSubCategory ? $task->taskSubCategory->name : '' }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label"><b>Checklist
                                : </b></label></br>
                        <label class="control-label">{{ $task->checkList ? $task->checkList->name : '' }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label"><b>Description
                                : </b></label></br>
                        <label class="control-label">
                            {!! $task->description ? strip_tags($task->description) : '' !!}
                        </label>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection