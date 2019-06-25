@extends('frontend.layouts.master')

@section('second-title')
    | Franchise {{ $network->name }}
@stop
@section('url-way')
    <li>
        <a href="#">Réseaux</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{url('/network/list/franchise')}}">Franchise</a>
        <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">{{ $network->name }}</a>
    </li>
@stop

@section('header')
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/css/cubeportfolio.css')?> "
          rel="stylesheet" type="text/css">
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/portfolio.min.css')?> " rel="stylesheet"
          type="text/css"/>

@endsection
@section('title')
    Franchise {{ $network->name }}
@endsection
@section('content')
    <div class="tabbable-line" id="tabs">
        <ul class="nav nav-tabs ">
            <li class="active">
                <a href="#tab_15_1" data-toggle="tab" aria-expanded="true"> Détails </a>
            </li>
            <li class="">
                <a href="#tab_15_2" data-toggle="tab" aria-expanded="false"> Dernière visite </a>
            </li>
            <li class="">
                <a href="#tab_15_3" data-toggle="tab"> Dernière visite branding </a>
            </li>
            <li class="">
                <a href="#tab_15_4" data-toggle="tab" aria-expanded="false" id="tab1"> Dernière visite display </a>

            </li>
            <li class="">
                <a href="#tab_15_5" data-toggle="tab" aria-expanded="false" id="tab2"> Dernière visite online </a>

            </li>
            <li class="">
                <a href="#tab_15_6" data-toggle="tab" aria-expanded="true">Stocks des ilvs </a>

            </li>
            <li class="">
                <a href="#tab_15_7" data-toggle="tab" aria-expanded="true">Historique </a>

            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_15_1">
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="portlet dark box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-info"></i>Détails boutique
                                </div>
                                <div class="actions">

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Code :</div>
                                    <div class="col-md-7 value"> #{{ $network->code }}

                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Nom:</div>
                                    <div class="col-md-7 value"> {{ $network->name }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Responsable:</div>
                                    <div class="col-md-7 value">
                                        {{ $network->responsible }}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Téléphone :</div>
                                    <div class="col-md-7 value"> {{ $network->phone ? $network->phone : '' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Téléphone 2 :</div>
                                    <div class="col-md-7 value"> {{ $network->phone2 ? $network->phone2 : '' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Téléphone fixe :</div>
                                    <div class="col-md-7 value"> {{ $network->land_line ? $network->land_line : '' }}</div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="portlet blue-chambray box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-map-marker"></i>Adresse
                                </div>
                                <div class="actions">

                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Adresse :</div>
                                    <div class="col-md-7 value"> {!! strip_tags($network->address) !!}

                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Ville :</div>
                                    <div class="col-md-7 value"> {{ $network->city ? $network->city->name : '' }}

                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Gouvernerat:</div>
                                    <div class="col-md-7 value"> {{ $network->city ? $network->city->governorate : '' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Délégation:</div>
                                    <div class="col-md-7 value">
                                        {{ $network->city ? $network->city->delegation : '' }}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Zone :</div>
                                    <div class="col-md-7 value"> {{ $network->city ? $network->city->zone->value : '' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Code postal :</div>
                                    <div class="col-md-7 value"> {{ $network->postal_code ? $network->postal_code : '' }}</div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="tab-pane" id="tab_15_2">
                @if($daily_visit)
                    <div class="row">


                        <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                           href="{{ url('visits/daily/'.$daily_visit->id) }}"
                           style="float: right;margin-right: 10px;"><i
                                    class="fa fa-tv"></i> Plus de détails</a>


                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $daily_visit ? $daily_visit->visit_date->format('d/m/Y') : '' }} </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Envoyé le : </b></label></br>
                                <label class="control-label">{{ $daily_visit ? $daily_visit->updated_at->format('d/m/Y') : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">#{{ $network->code }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">Quotidienne</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label"> {{ $network->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser :</b>
                                </label></br>
                                <label class="control-label">{{ $daily_visit ? $daily_visit->user->name : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="well margin-top-10">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12 text-stat">
                                    <center><span class="label label-success"> B.Merch: </span>
                                        <h3>{{ $daily_visit ? $daily_visit->bmerch. ' %' : '' }} </h3></center>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 text-stat">
                                    <center><span class="label label-danger"> Anomalies: </span>
                                        <h3>{{ $daily_visit ? $daily_visit->anomalies.' %' : '' }}</h3></center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-bordered table-hover" id="rapport_table">
                        <thead>
                        <tr style="background-color: rgba(2, 2, 2, 0.06)">
                            <th style=" color: #F2784B; width: 10%;"> Catégorie</th>
                            <th style=" color: #F2784B; width: 20%;"> Sous-catégorie</th>
                            <th style=" color: #F2784B; width: 50%;"> Description</th>
                            <th style=" color: #F2784B; width: 5%; text-align: center; "> Statut</th>
                            <th style=" color: #F2784B; width: 10%; text-align: center;"> Image</th>
                            <th style=" color: #F2784B; width: 5%; text-align: center;"> Commantaire</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($daily_visit->answers as $answer)
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    Pas de Visite Quotidienne
                @endif
            </div>
            <div class="tab-pane" id="tab_15_3">
                @if($branding_visit)
                    <div class="row">

                        <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                           href="{{ url('visits/branding/'.$branding_visit->id) }}"
                           style="float: right;margin-right: 10px;"><i
                                    class="fa fa-registered"></i>Plus de détails</a>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $branding_visit ? $branding_visit->visit_date->format('d/m/Y') : '' }} </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Envoyé le : </b></label></br>
                                <label class="control-label">{{ $branding_visit ? $branding_visit->updated_at->format('d/m/Y') : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">#{{ $network->code }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">Branding</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label"> {{ $network->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser :</b>
                                </label></br>
                                <label class="control-label">{{ $branding_visit ? $branding_visit->user->name : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="portfolio-content portfolio-1">
                            <div id="js-filters-juicy-projects2" class="cbp-l-filters-button">
                                <div data-filter="*"
                                     class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">
                                    Tous
                                    <div class="cbp-filter-counter"></div>
                                </div>
                                @if($branding_categories)
                                    @for($i=0; $i<sizeof($branding_categories); $i++)
                                        <div data-filter=".{{ $branding_categories[$i]['code'] }}"
                                             class="cbp-filter-item btn dark btn-outline uppercase">
                                            {{ $branding_categories[$i]['value'] }}
                                            <div class="cbp-filter-counter"></div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <div id="js-grid-juicy-projects2" class="cbp">
                                @foreach($branding_photo_sets as $photo_set)
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
                                            <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">
                                                {{ $photo->photoSet->photoCategory->value }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    Pas de Visite Branding
                @endif

                <div class="row"></div>
            </div>
            <div class="tab-pane" id="tab_15_4">
                @if($display_visit)
                    <div class="row">

                        <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                           href="{{ url('visits/display/'.$display_visit->id) }}"
                           style="float: right;margin-right: 10px;"><i
                                    class="fa fa-tv"></i>Plus de détails</a>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $display_visit ? $display_visit->visit_date->format('d/m/Y') : '' }} </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Envoyé le : </b></label></br>
                                <label class="control-label">{{ $display_visit ? $display_visit->updated_at->format('d/m/Y') : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">#{{ $network->code }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">Display</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label"> {{ $network->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser :</b>
                                </label></br>
                                <label class="control-label">{{ $display_visit ? $display_visit->user->name : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="portfolio-content portfolio-1">
                            <div id="js-filters-juicy-projects" class="cbp-l-filters-button">
                                <div data-filter="*"
                                     class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">
                                    Tous
                                    <div class="cbp-filter-counter"></div>
                                </div>
                                @if($display_categories)
                                    @for($i=0; $i<sizeof($display_categories); $i++)
                                        <div data-filter=".{{ $display_categories[$i]['code'] }}"
                                             class="cbp-filter-item btn dark btn-outline uppercase">
                                            {{ $display_categories[$i]['value'] }}
                                            <div class="cbp-filter-counter"></div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <div id="js-grid-juicy-projects" class="cbp">
                                @foreach($display_photo_sets as $photo_set)
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
                                            <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">
                                                {{ $photo->photoSet->photoCategory->value }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    Pas de visite Display
                @endif
            </div>
            <div class="tab-pane" id="tab_15_5">
                @if($online_visit)
                    <div class="row">

                        <a class="btn btn-sm dark" id="btn-detail" title="Détail visite branding"
                           href="{{ url('visits/online/'.$online_visit->id) }}"
                           style="float: right;margin-right: 10px;"><i
                                    class="fa fa-map-o"></i> Plus de détails</a>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Date
                                        : </b></label></br>
                                <label class="control-label">{{ $online_visit ? $online_visit->visit_date->format('d/m/Y') : '' }} </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Envoyé le : </b></label></br>
                                <label class="control-label">{{ $online_visit ? $online_visit->updated_at->format('d/m/Y') : '' }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Code : </b></label></br>
                                <label class="control-label">#{{ $network->code }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Type
                                        : </b></label></br>
                                <label class="control-label">Online</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Réseau : </b></label></br>
                                <label class="control-label"> {{ $network->name }}</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label"><b>Merchandiser :</b>
                                </label></br>
                                <label class="control-label">{{ $online_visit ? $online_visit->user->name : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="portfolio-content portfolio-1">
                            <div id="js-filters-juicy-projects3" class="cbp-l-filters-button">
                                <div data-filter="*"
                                     class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">
                                    Tous
                                    <div class="cbp-filter-counter"></div>
                                </div>
                                @if($online_categories)
                                    @for($i=0; $i<sizeof($online_categories); $i++)
                                        <div data-filter=".{{ $online_categories[$i]['code'] }}"
                                             class="cbp-filter-item btn dark btn-outline uppercase">
                                            {{ $online_categories[$i]['value'] }}
                                            <div class="cbp-filter-counter"></div>
                                        </div>
                                    @endfor
                                @endif
                            </div>
                            <div id="js-grid-juicy-projects3" class="cbp">
                                @foreach($online_photo_sets as $photo_set)
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
                                            <div class="cbp-l-grid-projects-desc uppercase text-center uppercase text-center">
                                                {{ $photo->photoSet->photoCategory->value }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    Pas De Visite Online
                @endif
            </div>
            <div class="tab-pane" id="tab_15_6">
                <div class="row" style="margin-top: 10px;">

                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption font-dark"><span class="caption-subject bold uppercase"><i
                                            class="icon-basket"></i> Liste des ilvs</span></div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover" id="ilv_table">
                                <thead>
                                <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                    <th style="  width: 70%;"> Nom</th>
                                    <th style="  width: 70%;"> Date de la visite</th>
                                    <th style="  width: 30%;text-align: center;"> Etat</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="tab_15_7">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-info font-dark"></i>
                            <span class="caption-subject bold uppercase">Historique</span>
                        </div>
                        <div class="tools">

                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">


                            <form id="myform">
                                <table id="mytable" style="">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
										<div class="col-lg-4 col-md-2 col-sm-6 col-xs-12"></div>
										<div class="col-lg-4 col-md-2 col-sm-6 col-xs-12">
											<div class="dashboard-stat blue">
												<div class="visual">
													<i class="fa fa-user"></i>
												</div>
												<div class="details">
													<div class="number">
														<span data-counter="counterup">{{ $visits_number }}</span>
													</div>
													<div class="desc"> Nombre total des visites</div>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-2 col-sm-6 col-xs-12"></div>
                                    </tr>
                                    </tbody>

                                </table>
                            </form>

                        </div>
                        <div class="row" style="margin-top: 20px;">

                            <table class="table table-striped table-bordered table-hover" id="histo_table">
                                <thead>
                                <tr style="background-color: rgba(2, 2, 2, 0.06)">
                                    <th style=" color: #F2784B; width: 7%;"> Date</th>
                                    <th style=" color: #F2784B; width: 20%;"> Anomalies</th>
                                    <th style=" color: #F2784B; width: 10%; text-align: center; "> B.Merch</th>
                                    <th style=" color: #F2784B; width: 20%; text-align: center; valign:center;">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    </div>

@endsection
@section('footer')
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/pages/scripts/portfolio-11.js')?> "
            type="text/javascript"></script>
    <script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
            type="text/javascript"></script>


    <script>
        $(function () {
            $('#rapport_table').DataTable({
                "bPaginate": false,
                "bInfo": false,
                responsive: true

            });
            $('#ilv_table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
                "iDisplayLength": 10,
                "bFilter": true,
                "bSort": false,
                "ajax": {
                    'url': "{{ url('/ilv_network/paginateILVPerNetwork/'.$network->id) }}",
                    'type': 'get',
                    'data': function (d) {
                        d.page = Math.ceil(d.start / d.length) + 1;
                    }
                },
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [2],
                        "className": 'dt-body-center'
                    }
                ]

            });

            var table = $('#histo_table').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [[5, 10, 15, 20, 50], [5, 10, 15, 20, 50]],
                "iDisplayLength": 10,
                "bFilter": false,
                "bSort": false,
                "ajax": {
                    'url': "{{ route('network.history.paginate', $network->id) }}",
                    'type': 'get',
                    'data': function (d) {
                        d.page = Math.ceil(d.start / d.length) + 1;
                    }
                },
                responsive: true,
                "columnDefs": [
                    {
                        "targets": [3],
                        "className": 'dt-body-center'
                    }
                ]
            });

            function netoyer() {
                document.getElementById("myform").reset();
                $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            return true;
                        }
                );
                $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(function (settings, data, dataIndex) {
                    return true;
                }));
                table.draw();
            }
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