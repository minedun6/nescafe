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

    <link href="<?php echo URL::asset('/frontend/assets/global/plugins/cubeportfolio/css/cubeportfolio.css')?> "
          rel="stylesheet" type="text/css">
    <link href="<?php echo URL::asset('/frontend/assets/pages/css/portfolio.min.css')?> " rel="stylesheet"
          type="text/css"/>

</head>


<body>


<h3 class="page-title">
    @yield('title')
</h3>


<div class="row">
    <h1> Pas de visite </h1>
</div>


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
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>