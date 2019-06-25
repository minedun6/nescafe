@extends('frontend.layouts.master')

@section('second-title')
    | Modifier une tâche
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
        <a href="#">Modifier une tâche</a>
    </li>
@stop


@section('content')
    @if($errors->any())
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
    <div class="portlet box dark">
        <div class="portlet-title">
            <div class="caption">
                Editer une tâche
            </div>
        </div>
        <div class="portlet-body">
            <form action="{{ url('/tasks/edit/'.$task->id) }}" method="post" enctype="multipart/form-data"
                  id="document_form">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Catégorie</label>
                            <input type="text" class="form-control" name="category"
                                   value="{{ $task->taskSubCategory ? ($task->taskSubCategory->taskCategory ? $task->taskSubCategory->taskCategory->name : '') : '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sous catégorie</label>
                            <input type="text" class="form-control" name="subcategory"
                                   value="{{ $task->taskSubCategory ? $task->taskSubCategory->name  : '' }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Checklist</label>
                            <select class="form-control" name="check_list_id">
                                @foreach($check_lists as $check_list)
                                    @if($task->checkList && $check_list->id == $task->checkList->id)
                                        <option selected value="{{ $check_list->id }}">{{ $check_list->name }}</option>
                                    @else
                                        <option value="{{ $check_list->id }}">{{ $check_list->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="4"
                                      name="description">{{ $task->description ? strip_tags($task->description) : '' }}</textarea>
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
