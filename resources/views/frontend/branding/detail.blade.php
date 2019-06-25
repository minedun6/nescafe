@extends('frontend.layouts.master')

@section('second-title')
    | Détails visite du {{ $visit->visit_date->format('d/m/Y') }}
@stop
@section('url-way')
    <li>
        <a href="#">Visites</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/visits/branding')}}">Visites branding</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $visit->visit_date->format('d/m/Y') }}</a>
    </li>
@stop


@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/css/cubeportfolio.css')?> "
          rel="stylesheet" type="text/css">
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
                        <i class="icon-info font-dark"></i>
                        <span class="caption-subject bold uppercase">Détails visite branding</span>
                        @if($visit->is_answered_branding)
                            <small style="font-size: 14px;
    letter-spacing: 0;
    font-weight: 300;
    color: #888;">Envoyée le {{ $visit->updated_at }} </small>
                        @endif

                    </div>
                    <div class="tools">
                        <div class="dt-buttons">
                            @if(!$visit->is_answered_branding)
                                <a class="dt-button buttons-print btn dark btn-outline"
                                   href="{{ url('photos/add/branding/'.$visit->id) }}"><i class="fa fa-plus-circle"></i>
                                    Ajouter une visite branding</a>
                                @permission('edit-visits') <a
                                        class="dt-button buttons-print btn blue-chambray btn-outline"
                                        data-target="#pop_up"
                                        data-toggle="modal" style="padding-left: 3px; "> <i
                                            class="fa fa-edit"></i> Editer date
                                </a>@endauth
                            @endif
                            @if($supervisor_note == true)
                                <a tabindex="0" class="dt-button buttons-print btn blue btn-outline"
                                   data-target="#msg_form" data-toggle="modal"><span><i
                                                class="fa fa-envelope"></i> Note superviseur</span></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $visit->visit_date->format('d/m/Y') }}</label>
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
                                <label class="control-label"><b>Réseau
                                        : </b></label></br>
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
                            <a class="btn btn-sm dark" id="btn-detail" title="Détail visite quotidienne"
                               href="{{ url('visits/daily/'.$visit->id) }}"><i
                                        class="fa fa-calendar"></i></a>
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
                        <form action="{{ url('/note/pictures/') }}" method="post">
                            <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                            @if($visit->is_answered_branding)
                                <div class="portfolio-content portfolio-1">
                                    <div id="js-filters-juicy-projects" class="cbp-l-filters-button">
                                        <div data-filter="*"
                                             class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">
                                            Tous
                                            <div class="cbp-filter-counter"></div>
                                        </div>
                                        @for($i=0; $i<sizeof($categories); $i++)
                                            <div data-filter=".{{ $categories[$i]['code'] }}"
                                                 class="cbp-filter-item btn dark btn-outline uppercase">
                                                {{ $categories[$i]['value'] }}
                                                <div class="cbp-filter-counter"></div>
                                            </div>
                                        @endfor
                                    </div>
                                    <div id="js-grid-juicy-projects" class="cbp">
                                        <?php $w = 0; ?>
                                        @foreach($visit_photo_sets as $photo_set)
                                            <?php $w++; ?>
                                            @foreach($photo_set->photos as $photo)
                                                <div class="cbp-item {{ $photo->photoSet->photoCategory->code }}">
                                                    <div class="cbp-caption">
                                                        <div class="cbp-caption-defaultWrap">
                                                            <img src="{{ url('/photos/'.$photo->path) }}"
                                                                 alt="{{ $photo->photoSet->photoCategory->value }}">
                                                        </div>
                                                        <div class="cbp-caption-activeWrap">
                                                            <div class="cbp-l-caption-alignCenter">
                                                                <div class="cbp-l-caption-body">
                                                                    <a href="{{ url('/photos/'.$photo->path) }}"
                                                                       class="cbp-lightbox cbp-l-caption-buttonRight btn red uppercase btn red uppercase"
                                                                       data-title="">Aperçu</a>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center"
                                                         style="text-overflow:clip;overflow: visible;white-space: normal;">
                                                        {{ $photo->photoSet->photoCategory->value }} <br>

                                                    </div>
                                                    @if( $photo->description)
                                                        <div class="cbp-l-grid-projects-desc  text-center "
                                                             style="text-overflow:clip;overflow: visible;white-space: normal;">
                                                            <b>Commentaire : </b> {{$photo->description }}
                                                        </div> @endif
                                                    <div class="cbp-l-grid-projects-desc  text-center "
                                                         style="text-overflow:clip;overflow: visible;white-space: normal;">
                                                        <b>Note </b>
                                                        @if($photo->note_photo != null)
                                                            {{ $photo->note_photo->message }}
                                                        @else
                                                            <input type="text" class="form-control"
                                                                   name="note[]">
                                                            <input type="hidden" name="picture_id[]"
                                                                   value="{{ $photo->id }}">
                                                        @endif
                                                    </div>
                                                </div>

                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn dark" type="submit"
                                            style="float: right;margin-right: 30px;">Envoyer
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                    <!-- ///////////////////////////////////// message form ////////////////////////////// -->
                    <div class="modal fade" id="msg_form" tabindex="-1" role="basic" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true"></button>
                                    <h4 class="modal-title" style="color: #F2784B;"> Note superviseur</h4>
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
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/pages/scripts/portfolio-1.min.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>
    <script>
        $('#rapport_table').DataTable({
            "bPaginate": false,
            "bInfo": false
        });
    </script>
    <script>
        function set_link(link) {
            document.getElementById("img_pop").setAttribute("src", link);

        }
    </script>
@endsection