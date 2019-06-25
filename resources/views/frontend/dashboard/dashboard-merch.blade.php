@extends('frontend.layouts.master')



@section('content')

<div class="row">   <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16"></div>
    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16" style="cursor: pointer" onclick="window.location='{{ url('planning') }}'">
        <div class="dashboard-stat red-intense">
            <div class="visual">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="details">
                <div class="number">
<i class="fa fa-arrow-right"></i>
                </div>
                <div class="desc"> Mon planning</div>
            </div>

        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16"></div>
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Stats visites/réponses</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body">
                    <div id="echarts_bar" style="height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16">
            <div class="dashboard-stat blue">
                <div class="visual">
                    <i class="fa fa-calculator"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="100">100</span>
                    </div>
                    <div class="desc"> Total Visites de mois</div>
                </div>
                <a class="more" href="{{ url('/visits/daily') }}"> Consulter la liste
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16">
            <div class="dashboard-stat red">
                <div class="visual">
                    <i class="fa fa-archive"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1200,5">1200,5</span></div>
                    <div class="desc"> Total visites branding de mois </div>
                </div>
                <a class="more" href="{{ url('/visits/branding') }}"> Consulter la liste
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-16">
            <div class="dashboard-stat purple">
                <div class="visual">
                    <i class="fa fa-calculator"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="1000">1000</span>
                    </div>
                    <div class="desc"> Total visites display de mois</div>
                </div>
                <a class="more" href="{{ url('/visits/display') }}"> Consulter la liste
                    <i class="m-icon-swapright m-icon-white"></i>
                </a>
            </div>
        </div>

    </div>

@endsection

@section('footer')



    <script src="<?php echo URL::asset('/frontend/assets/scripts/graph.init.js')?> " type="text/javascript"></script>


    @endsection