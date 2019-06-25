<!DOCTYPE html>
<!--[if IE 8]>
<html lang="fr" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="fr" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="fr">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8"/>
    <title>Nescafe @yield('second-title')</title>
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
    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/chosen/chosen.min.css')?>"
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


    <link rel="shortcut icon" href="{{ URL::asset('logo-nescafe.jpg') }}"/>
    <link href="<?php echo URL::asset('/frontend/assets/global/css/responsive-table.css')?>" rel="stylesheet"
          type="text/css"/>
    @yield('header')

</head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white black-body">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top black-nav">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                <img src="<?php echo URL::asset('frontend/assets/layouts/layout/img/logoTrans.png')?>" alt=""
                     class="logo-default" style="margin: 4px 0 0; margin-left: 22px;"/> </a>
            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
           data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                @roles(['Super Administrator', 'Superviseur', 'Visiteur'])
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                       data-close-others="true">
                        <i class="icon-bell" style="color: white;"></i>
                        @if($alerts->count() > 0)
                            <span class="badge badge-danger"
                                  style="background-color: #ff2528;"> {{ $alerts->count() }} </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3>
                                <span class="bold">{{ $alerts->count() }} </span> notifications</h3>
                            <a href="{{ url('/alerts') }}">Voir plus...</a>
                        </li>
                        <li>
                            <div class="slimScrollDiv"
                                 style="position: relative; overflow: hidden; width: auto; height: 250px;">
                                <ul class="dropdown-menu-list scroller"
                                    style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283"
                                    data-initialized="1">
                                    @foreach($alerts as $alert)
                                        @if($alert->target_type == 'ilv')
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{ $alert->created_at ? $alert->created_at->format('d/m H:i') : '' }}</span>
                                                <span class="details alert-content-msg">
                                                    <span class="label label-sm label-icon label-success">
                                                        <i class="fa fa-battery-empty"></i>
                                                    </span> {!! $alert->message != '' ? strip_tags($alert->message) : '' !!} </span>
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">{{ $alert->created_at ? $alert->created_at->format('d/m H:i') : '' }}</span>
                                                <span class="details alert-content-msg">
                                                    <span class="label label-sm label-icon label-danger">
                                                        <i class="fa fa-bolt"></i>
                                                    </span> {!! $alert->message != '' ? strip_tags($alert->message) : '' !!} </span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="slimScrollBar"
                                     style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; background: rgb(99, 114, 131);"></div>
                                <div class="slimScrollRail"
                                     style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(234, 234, 234);"></div>
                            </div>
                        </li>
                    </ul>
                </li>
                @endauth
                <li class="dropdown dropdown-user">
                    <a href="">
                        <span class="username username-hide-on-mobile" id="link_navbar"
                              style="color: #fff">  <i
                                    class="icon-settings"></i> {!! \App\Services\Access\Facades\Access::user()->name !!}</span></a>
                </li>
                <li class="dropdown dropdown-user">
                    <a href="{{ url('/logout') }}">
                        <span class="username username-hide-on-mobile" id="link_navbar"
                              style="color: #fff"> Déconnexion </span>
                        <i class="fa fa-sign-out" style="color: #fff"></i>
                    </a>

                </li>
                <!-- END QUICK SIDEBAR TOGGLER -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <div class="page-sidebar navbar-collapse collapse">

            <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true"
                data-slide-speed="200" style="padding-top: 20px">
                <li class="sidebar-toggler-wrapper hide">
                    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    <div class="sidebar-toggler"></div>
                    <!-- END SIDEBAR TOGGLER BUTTON -->
                </li>

                @role('Merch')
                <li class="nav-item start ">
                    <a href="{{ url('mydaily') }}" class="nav-link nav-toggle">
                        <i class="fa fa-eye"></i>
                        <span class="title">Mes visites de jour</span>

                    </a>
                </li>
                @endauth
                <li class="nav-item start ">
                    <a href="{{ url('planning') }}" class="nav-link nav-toggle">
                        <i class="fa fa-calendar-check-o"></i>
                        <span class="title">Planning</span>

                    </a>
                </li>
                @role('Merch')

                @else
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-check"></i>
                            <span class="title">Visites</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start ">
                                <a href="{{ url('/mydaily') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-check"></i>
                                    <span class="title">Les Visites du jour</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/visits/daily') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-calendar"></i>
                                    <span class="title">Visites checklist</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/visits/online') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-map-o"></i>
                                    <span class="title">Visites Online</span>

                                </a></li>
                        </ul>
                    </li>
			        <!--<li class="nav-item start ">
                        <a href="{{ url('/ilv') }}" class="nav-link nav-toggle">
                            <i class="icon-basket"></i>
                            <span class="title">ILV</span>

                        </a>
                    </li> -->


                    <!--////////////////////////////Réseau //////////////////////// -->
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-users"></i>
                            <span class="title">Réseaux</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start ">
                                <a href="{{ url('network/list/pdvc') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-opencart"></i>
                                    <span class="title">Epiceries </span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('network/list/pdv') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-home"></i>
                                    <span class="title">Superettes </span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('network/list/pdvg') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-home"></i>
                                    <span class="title">Kiosques </span>

                                </a></li>
                        </ul>
                    </li>

                    @endauth
                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="fa fa-folder-open-o"></i>
                            <span class="title">Gestion des documents</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start ">
                                <a href="{{ url('/guideline') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-check"></i>
                                    <span class="title">Guidelines</span>

                                </a></li>
                            <!--<li class="nav-item start ">
                                <a href="{{ url('/technic_file') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-calendar"></i>
                                    <span class="title">Fiches techniques</span>

                                </a></li> -->

                        </ul>
                    </li>
                    @role('Visiteur')

                    @else
                            <!--<li class="nav-item start ">
                        <a href="{{ url('/service/note/') }}" class="nav-link nav-toggle">
                            <i class="fa fa-sticky-note-o"></i>
                            <span class="title">Notes de service</span>

                        </a>

                    </li>
                    <li class="nav-item start ">
                        <a href="{{ url('chat') }}" class="nav-link nav-toggle">
                            <i class="icon-bubble "></i>
                            <span class="title">Messagerie</span>

                        </a>

                    </li>-->
                    @endauth
					@role('Merch')

					@else
					<li class="nav-item start ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Statistiques</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start ">
                                <a href="{{ url('/checklists') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-check"></i>
                                    <span class="title">Checklists</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/networks') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-users"></i>
                                    <span class="title">Réseaux</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/visites') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-map-o"></i>
                                    <span class="title">Visites</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/merchandiser') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-opencart"></i>
                                    <span class="title"> Merchandisers</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/ilv') }}" class="nav-link nav-toggle">
                                    <i class="icon-basket"></i>
                                    <span class="title"> ILV</span>

                                </a></li>
                        </ul>
                    </li>
					
                    
					@role('Visiteur')

                    @else

                    <li class="nav-item start ">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-settings "></i>
                            <span class="title">Paramêtres</span>
                            <span class="arrow"></span>
                        </a>
                        <ul class="sub-menu">
                            @role('Administrator')
                                    <!--<li class="nav-item start ">
                                <a href="{{ url('/admin/planning') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Générateur de planning</span>

                                </a></li>-->
                            @endauth
                            @role('Super Administrator')
                                    <li class="nav-item start ">
                                <a href="{{ url('/admin/planning') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Générateur de planning</span>

                                </a></li>
                            @endauth
                            <li class="nav-item start ">
                                <a href="{{ url('/tasks') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-tasks"></i>
                                    <span class="title">Gestion des tâches</span>

                                </a></li>
                            <li class="nav-item start ">
                                <a href="{{ url('/setting') }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">Paramêtres globaux</span>
                                </a></li>
                        </ul>
                    </li>
					
					@endauth

					@endauth




            </ul>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <div class="theme-panel hidden-xs hidden-sm"></div>
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="/">Accueil</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    @yield('url-way')
                </ul>

            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->

            <h3 class="page-title">
                @yield('title')
            </h3>
            @yield('content')
                    <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>

        <!-- END QUICK SIDEBAR -->
    </div>

    <!-- END CONTAINER -->
</div>

<!-- BEGIN FOOTER -->
<div class="page-footer">
    <div class="page-footer-inner">

    </div>
    <div class="scroll-to-top" style="padding-bottom: 20px">
        <i class="icon-arrow-up"></i>
    </div>
</div>
<!-- END FOOTER -->
<!--[if lt IE 9]>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/respond.min.js')?>"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/excanvas.min.js' )?>"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap/js/bootstrap.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/js.cookie.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')?>"
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
<script src="{{ URL::asset('/frontend/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/frontend/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"
        type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset('/frontend/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('/frontend/assets/global/plugins/datatables/datatables.min.js') }}"
        type="text/javascript"></script>
<script src="{{ URL::asset('/frontend/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
        type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo URL::asset('/frontend/assets/global/scripts/app.min.js')?>" type="text/javascript"></script>


<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/moment.min.js')?>" type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/fileinput/fileinput.js') ?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/global/plugins/chosen/chosen.jquery.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/scripts/jquery.datatables.js')?> " type="text/javascript"></script>

<script src="<?php echo URL::asset('/frontend/assets/scripts/script.init.js')?> " type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/scripts/form-val.js')?> " type="text/javascript"></script>
<script>
$(function () {
    setNavigation();
});

function setNavigation() {
    var path = window.location.href;

    $(".nav-item a").each(function () {
        var href = $(this).attr('href');
        if (path.indexOf(href)>= 0) {
            $(this).closest('li').addClass('active');
            $(this).closest('li').addClass('open');
        }
        if ($('.active').parent().parent().is('li')) {
            $('.active').parent().parent().addClass('open');
            $('.active').parent().parent().addClass('active');
            $('.active').parent().css({"display": "block"});
        }
        if ($('.active').parent().parent().parent().parent().is('li')) {
            $('.active').parent().parent().parent().parent().addClass('open');
            $('.active').parent().parent().parent().parent().addClass('active');
            $('.active').parent().parent().parent().css({"display": "block"});
        }

        
    });
}

</script>

@yield('footer')
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="<?php echo URL::asset('/frontend/assets/layouts/layout/scripts/layout.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/layouts/layout/scripts/demo.min.js')?>"
        type="text/javascript"></script>
<script src="<?php echo URL::asset('/frontend/assets/layouts/global/scripts/quick-sidebar.min.js')?>"
        type="text/javascript"></script>

<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>