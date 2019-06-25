@extends('frontend.layouts.master')
@section('content')

    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Détail fiche technique
            </div>
            <div class="tools">

            </div>
        </div>
        <div class="portlet-body">

            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a href="#tab_15_1" data-toggle="tab">Détails </a>
                    </li>

                    @role('Merch')
                    @else
                        <li>
                            <a href="#tab_15_2" data-toggle="tab"> Historiques des lectures </a>
                        </li>
                        @endauth

                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_15_1">


                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Nom
                                            : </b></label></br>
                                    <label class="control-label">{{ $technic_file->nom }}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Cible : </b></label></br>
                                    <label class="control-label">{{ $technic_file->cible }}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Fichier
                                            : </b></label></br>
                                    @if($technic_file->path)
                                        <label class="control-label">{{ $technic_file->path }}

                                            <a href="{{ url('/technic_file/download/'.$technic_file->id) }}"><i
                                                        class="fa fa-download"></i>
                                            </a> </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Réseau
                                            : </b></label></br>
                                    <label class="control-label"><?php if ($technic_file->network_type_id) echo $technic_file->network_type->value;?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Catégorie : </b></label></br>
                                    <label class="control-label">{{$technic_file->category}}</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label"><b>Sous-catégorie: </b></label></br>
                                    <label class="control-label">{{$technic_file->subcategory}}</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    @role('Merch')
                    @else
                        <div class="tab-pane" id="tab_15_2" aria-expanded="false">

                            <div class="portlet light bordered">

                                <div class="portlet-body">
                                    <!--BEGIN TABS-->


                                    <div class="slimScrollDiv"
                                         style="position: relative; overflow: hidden; width: auto; height: 290px;">
                                        <div class="scroller" style="height: 290px; overflow: hidden; width: auto;"
                                             data-always-visible="1" data-rail-visible1="1" data-initialized="1">
                                            <ul class="feeds">
                                                @foreach($logs as $log)
                                                    <li>
                                                        <a href="javascript:;">
                                                            <div class="col1">
                                                                <div class="cont">
                                                                    <div class="cont-col1">
                                                                        <div class="label label-sm label-success">
                                                                            <i class="fa fa-bell-o"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="cont-col2">
                                                                        <div class="desc"> {{ $log->user ? $log->user->name : '' }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">{{ $log->created_at ? $log->created_at->format('d/m/Y H:i') : '' }}</div>
                                                            </div>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="slimScrollBar"
                                             style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(187, 187, 187);"></div>
                                        <div class="slimScrollRail"
                                             style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div>
                                    </div>
                                </div>
                            </div>
                            <!--END TABS-->
                        </div>

                        @endauth
                </div>

            </div>

        </div>
    </div>
@endsection