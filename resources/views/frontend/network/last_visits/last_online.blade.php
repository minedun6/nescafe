<!DOCTYPE html>

<html lang="fr">


<head>
    <meta charset="utf-8"/>
    <title>Orange @yield('second-title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/font-awesome/css/font-awesome.min.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/simple-line-icons/simple-line-icons.min.css')?>"
          rel="stylesheet" type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap/css/bootstrap.min.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/uniform/css/uniform.default.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('/frontend/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ URL::asset('/frontend/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}"
          rel="stylesheet"
          type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/datatables/datatables.min.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')?>"
          rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>"
          rel="stylesheet"
          type="text/css"/>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo URL::asset('/frontend/assets/global/css/components-rounded.min.css')?>" rel="stylesheet"
          id="style_components"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/css/plugins.min.css')?>" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo URL::asset('/frontend/assets/layouts/layout/css/layout.min.css')?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/layouts/layout/css/themes/default.css')?>" rel="stylesheet"
          type="text/css" id="style_color"/>
    <link href="<?php echo URL::asset('/frontend/assets/layouts/layout/css/custom.min.css')?>" rel="stylesheet"
          type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->


    <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/css/responsive-table.css')?>" rel="stylesheet"
          type="text/css"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/css/cubeportfolio.css')?> "
          rel="stylesheet" type="text/css">
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/portfolio.min.css')?> " rel="stylesheet"
          type="text/css"/>
</head>


<body>

<!-- BEGIN CONTENT BODY -->


@if($visit)

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label"><b>Date
                        : </b></label></br>
                <label class="control-label">{{ $visit ? $visit->visit_date->format('d/m/Y') : '' }} </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label"><b>Envoyé le : </b></label></br>
                <label class="control-label">{{ $visit ? $visit->updated_at->format('d/m/Y') : '' }}</label>
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
                <label class="control-label">online</label>
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
                <label class="control-label">{{ $visit ? $visit->user->name : '' }}</label>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="portfolio-content portfolio-1">
            <div id="js-filters-juicy-projects1" class="cbp-l-filters-button">
                <div data-filter="*"
                     class="cbp-filter-item-active cbp-filter-item btn dark btn-outline uppercase">
                    Tous
                    <div class="cbp-filter-counter"></div>
                </div>
                @if($categories)
                    @for($i=0; $i<sizeof($categories); $i++)
                        <div data-filter=".{{ $categories[$i]['code'] }}"
                             class="cbp-filter-item btn dark btn-outline uppercase">
                            {{ $categories[$i]['value'] }}
                            <div class="cbp-filter-counter"></div>
                        </div>
                    @endfor
                @endif
            </div>
            <div id="js-grid-juicy-projects1" class="cbp">
                @foreach($photo_sets as $photo_set)
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
    Pas de visite online
@endif


<![endif]-->
<!-- BEGIN CORE PLUGINS-->
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap/js/bootstrap.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/js.cookie.min.js')?>"
        type="text/javascript"></script>

<script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery.blockui.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/uniform/jquery.uniform.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')?>"
        type="text/javascript"></script>
<script src="{{ URL::asset('/frontend/assets/global/plugins/select2/js/select2.full.min.js') }}"
        type="text/javascript"></script>


<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->


<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS-->


<script src="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/js/jquery.cubeportfolio.min.js')?> "
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/pages/scripts/portfolio-11.js')?> "
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery-ui/jquery-ui.min.js')?> "
        type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->


<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>