@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('navs.frontend.dashboard') }}</div>

                <div class="panel-body">
                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('navs.frontend.user.my_information') }}</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div role="tabpanel" class="tab-pane active" id="profile">
                                <table class="table table-striped table-hover table-bordered dashboard-table">

                                    <tr>
                                        <th>{{ trans('labels.frontend.user.profile.name') }}</th>
                                        <td>{!! $user->name !!}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ trans('labels.frontend.user.profile.email') }}</th>
                                        <td>{!! $user->email !!}</td>
                                    </tr>

                                    <tr>
                                        <th>{{ trans('labels.general.actions') }}</th>
                                        <td>
                                            <a href="{!! route('frontend.user.profile.edit') !!}" class="btn btn-primary btn-xs">{{ trans('labels.frontend.user.profile.edit_information') }}</a>

                                            @if ($user->canChangePassword())
                                                <a href="{!! route('auth.password.change') !!}" class="btn btn-warning btn-xs">{{ trans('navs.frontend.user.change_password') }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div><!--tab panel profile-->

                        </div><!--tab content-->

                    </div><!--tab panel-->

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection