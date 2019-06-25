@extends('frontend.layouts.master')

@section('second-title')
    | Détail note de service
@stop

@section('url-way')
    <li>
        <a href="{{url('/service/note')}}">Notes de service</a>
		<i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="#">Détail note de service</a>
    </li>
@stop


@section('content')
    <div class="portlet box yellow">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-info"></i>Détail note de service
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
                            <a href="#tab_15_2" data-toggle="tab"> Historique des lectures</a>
                        </li>
                        @endauth


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_15_1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"><b>Expediteur
                                            : </b></label></br>
                                    <label class="control-label">{{ $message->supervisor ? $message->supervisor->name : '' }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"><b>Objet
                                            : </b></label></br>
                                    <label class="control-label">{{ $message->object }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label"><b>Note
                                            : </b></label></br>
                                    <label class="control-label">
                                        {{ strip_tags($message->message) }}
                                    </label>
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
                                                @foreach($message->views as $view)
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
                                                                        <div class="desc"> {{ $view->user->name }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col2">
                                                                <div class="date">{{ $view->created_at ? $view->created_at->format('d/m/Y H:i') :'' }}</div>
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


@section('footer')

@endsection