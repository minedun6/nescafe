@extends('frontend.layouts.master')

@section('second-title')
    | {{ $visit->visit_date->format('d/m/Y') }}
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visits/daily')}}">Visites quotidiennes</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $visit->visit_date->format('d/m/Y') }}</a>
    </li>
@stop


@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/portfolio.min.css')?> " rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-info font-dark"></i><span class="caption-subject bold uppercase">Details visite quotidienne </span>
                        @if($visit->is_answered)
                            <small style="font-size: 14px;
    letter-spacing: 0;
    font-weight: 300;
    color: #888;">Envoyée le {{ $visit->updated_at }} </small>
                        @endif
                    </div>
                    <div class="tools">
                        <div class="dt-buttons">
                            @permission('add-visits')
                            @if(!$visit->is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('answers/add/'.$visit->id) }}"><i class="fa fa-plus-circle"></i>
                                    Ajouter une réponse</a>
                                @permission('edit-visits')
                                <a class="dt-button buttons-print btn blue-chambray btn-outline" data-target="#pop_up"
                                   data-toggle="modal" style="padding-left: 3px; "> <i class="fa fa-edit"></i> Editer
                                    date
                                </a>
                                @endauth
                            @endif
                            @endauth
                            @permission('edit-visits')
                            @if($visit->is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('/answers/edit/'.$visit->id) }}"><i
                                            class="fa fa-edit"></i> Editer
                                    la réponse</a>
                            @endif
                            @endauth
                            @role('Merch')
                            @if($can_edit && $visit->is_answered)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('answers/edit/'.$visit->id) }}"><i
                                            class="fa fa-edit"></i> Editer
                                    la réponse</a>
                            @endif
                            @endauth
                            @if($supervisor_note == true)
                                <a tabindex="0" class="dt-button buttons-print btn blue btn-outline"
                                   data-target="#msg_form" data-toggle="modal"><span><i
                                                class="fa fa-sticky-note-o"></i> Note superviseur</span></a>
                            @endif
                            <a tabindex="0" class="dt-button buttons-print btn red btn-outline"
                               aria-controls="sample_1"><span><i
                                            class="fa fa-file-pdf-o"></i> PDF</span></a>
                            <a tabindex="0" class="dt-button buttons-print btn blue btn-outline"
                               aria-controls="sample_1"><span><i class="fa fa-print"></i> Imprimer</span></a>

                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->visit_date->format('d/m/Y') }} </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">{{ $visit->network->code }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label">{{ $visit->network->name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network->type->value }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser : </b></label></br>
                                <label class="control-label">{{ $visit->user->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Zone
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network ? $visit->network->city->zone->value : '' }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Adresse
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->network->address }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Ville : </b></label></br>
                                <label class="control-label">{{ $visit->network->city->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                               href="{{ url('visits/branding/'.$visit->id) }}"><i
                                        class="fa fa-registered"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite display"
                               href="{{ url('visits/display/'.$visit->id) }}"><i
                                        class="fa fa-tv"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite online"
                               href="{{ url('visits/online/'.$visit->id) }}"><i
                                        class="fa fa-map-o"></i></a>
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite ilv"
                               href="{{ url('visits/ilv/'.$visit->id) }}"><i
                                        class="icon-basket"></i></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <label class="control-label"><b>Commentaire sur visite : </b></label></br>
                            <label class="control-label">{!! $visit->comment ? strip_tags($visit->comment) : '' !!}</label>
                        </div>

                    </div>

                    @if($visit->is_answered)
                        <div class="row">
                            <div class="well margin-top-10">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-stat">
                                        <center><span class="label label-success"> B.Merch: </span>
                                            <h3>{{ $visit->bmerch }} %</h3></center>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12 text-stat">
                                        <center><span class="label label-danger"> Anomalies: </span>
                                            <h3>{{ $visit->anomalies }} %</h3></center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <table class="table table-striped table-bordered table-hover" id="rapport_table">
                        @if($visit->is_answered)
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 10%;"> Catégorie</th>
                                <th style=" color: #F2784B; width: 20%;"> Sous-catégorie</th>
                                <th style=" color: #F2784B; width: 45%;"> Description</th>
                                <th style=" color: #F2784B; width: 5%; text-align: center; "> Statut</th>
                                <th style=" color: #F2784B; width: 10%; text-align: center;"> Image</th>
                                <th style=" color: #F2784B; width: 5%; text-align: center;"> Commentaire</th>
                                <th style=" color: #F2784B; width: 5%; text-align: center;"> Note</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($visit->answers as $answer)
                                <tr>
                                    <td> {{ $answer->task->taskSubCategory->taskCategory->name }}</td>
                                    <td> {{ $answer->task->taskSubCategory->name }}</td>
                                    <td> {{ $answer->task->description }}</td>
                                    @if($answer->value == 'ok')
                                        <?php $class = 'green';
                                        $value = 'OK';
                                        ?>
                                    @elseif($answer->value == 'ko')
                                        <?php $class = 'red';
                                        $value = 'KO';
                                        ?>
                                    @else
                                        <?php $class = 'yellow';
                                        $value = 'N/A';
                                        ?>
                                    @endif
                                    <td style="text-align: center"><span class="btn {{ $class }}">{{ $value }}</span>
                                    </td>
                                    <td style="text-align: center">
                                        @if($answer->photo)
                                            <a data-target="#img_reviewer"
                                               data-toggle="modal"
                                               class="btn btn-sm dark"
                                               onclick='set_link("{{ url('/photos/'.$answer->photo->path) }}") '>Aperçu
                                                <i class="fa fa-search"></i>
                                            </a>
                                        @else
                                            <a disabled="" data-target=""
                                               data-toggle="modal"
                                               class="btn btn-sm dark">Aperçu
                                                <i class="fa fa-search"></i>
                                            </a>
                                        @endif

                                    </td>
                                    <td style="text-align: center"><a class="btn btn-icon-only dark"
                                                                      @if($answer->comment != '') data-target="#comment_form_{{$answer->id}}"
                                                                      @else disabled="" data-target="" @endif
                                                                      data-toggle="modal">
                                            <i class="fa fa-envelope"></i>
                                        </a>
                                        <div class="modal fade" id="comment_form_{{$answer->id}}" tabindex="-1"
                                             role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>

                                                        <h4 class="modal-title" style="color: #F2784B;"> Commentaire
                                                            sur visite</h4>

                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form" method="post"
                                                              action="{{ url('/comment/answer/'.$answer->id) }}">
                                                            <input type="hidden" name="_token"
                                                                   value="{!! csrf_token() !!}">

                                                            @if($answer->comment != '')
                                                                <label> {{ $answer->comment }}</label>
                                                            @else
                                                                <label>Pas de commentaire</label>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>

                                        </div>
                                    </td>
                                    <td style="text-align: center"><a class="btn btn-icon-only dark"
                                                                      data-target="#note_form_{{$answer->id}}"
                                                                      data-toggle="modal">
                                            <i class="fa fa-sticky-note-o"></i>
                                        </a>
                                        <div class="modal fade" id="note_form_{{$answer->id}}" tabindex="-1"
                                             role="basic" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true"></button>
                                                        <h4 class="modal-title" style="color: #F2784B;"> Ajouter une
                                                            note</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form"
                                                              action="{{ url('/note/answer/'.$answer->id) }}"
                                                              method="post">
                                                            @if($answer->note_task != null)
                                                                {{ $answer->note_task->message }}
                                                            @else
                                                                <input type="hidden" name="_token"
                                                                       value="{!! csrf_token() !!}">
                                                                <label for="message">Note</label>
                                                                <textarea class="form-control"
                                                                          name="answer_note"
                                                                          id="visit_note__{{$answer->id}}"
                                                                          rows="2"></textarea>
                                                                <div class="modal-footer">
                                                                    <button class="btn dark" type="submit">
                                                                        Envoyer
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <thead>
                            <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                <th style=" color: #F2784B; width: 10%;"> Catégorie</th>
                                <th style=" color: #F2784B; width: 20%;"> Sous-catégorie</th>
                                <th style=" color: #F2784B; width: 45%;"> Description</th>
                                <th style=" color: #F2784B; width: 5%; text-align: center; "> Statut</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($visit->checklist->tasks as $task)
                                <tr>
                                    <td> {{ $task->taskSubCategory->taskCategory->name }}</td>
                                    <td> {{ $task->taskSubCategory->name }}</td>
                                    <td> {{ $task->description }}</td>

                                    <td style="text-align: center">-</td>

                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                    </table>
                    <!-- ///////////////////////////////////// image reviewer ////////////////////////////// -->
                    <div class="modal fade" id="img_reviewer" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title" id="img_title"></h4>
                                </div>
                                <div class="modal-body"><img id="img_pop" style="display: block; width: 98%; " src=""
                                                             alt=""></div>
                                <div class="modal-footer">
                                    <h5 class="modal-title" id="img_footer" style="text-align: left"></h5>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>

                    </div>

                    <!-- ///////////////////////////////////// message form ////////////////////////////// -->
                    <div class="modal fade" id="msg_form" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title" style="color: #F2784B;"> Note sur visite</h4>
                                </div>
                                <form role="form" action="{{ url('/note/visits/'.$visit->id) }}" method="post">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <div class="modal-body">
                                        <label for="message">Note</label>
                                        @if($visit->note_visit)
                                            <span>{!! strip_tags($visit->note_visit->message) !!}</span>
                                        @else
                                            <textarea class="form-control" name="message" id="message"
                                                      rows="2"></textarea>
                                        @endif

                                    </div>
                                    @if(!$visit->note_visit)
                                        <div class="modal-footer">
                                            <button class="btn dark" type="submit">Envoyer</button>
                                        </div>
                                    @endif
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>

                    </div>
                    <!-- ///////////////////////////////////// note sur visit form ////////////////////////////// -->

                    <div class="modal fade" id="pop_up" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title" style="color: #F2784B;"> Editer date</h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form" action="" onsubmit="">

                                        <label for="message">Date
                                            <input class="form-control form-control-inline input-small date-picker"
                                                   size="16" type="text"
                                                   value="{{ $visit->visit_date->format('d/m/Y') }} "/></label>


                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn dark" type="submit">Editer</button>

                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>

        $('.date-picker').datepicker();

    </script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>
    <script>
        $('#rapport_table').DataTable({
            "bPaginate": false,
            "bInfo": false,
            responsive: true

        });

    </script>
    <script>
        function set_link(link) {
            if (decodeURIComponent(link) != "") {
                document.getElementById("img_pop").setAttribute("src", decodeURIComponent(link));
            }
            else {
                return false;
            }
        }
    </script>

@endsection