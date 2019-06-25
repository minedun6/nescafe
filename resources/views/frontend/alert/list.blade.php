@extends('frontend.layouts.master')
@section('second-title')
    | Alertes
@stop

@section('url-way')
    <li>
        <a href="#">Alertes</a>
    </li>
@stop

@section('content')
    <div class="mt-element-list">
        <div class="mt-list-head list-default ext-1 font-white bg-dark">
            <div class="row">
                <div class="col-xs-8">
                    <div class="list-head-title-container">
                        <h3 class="list-title">Liste des notifications</h3>
                        <?php setlocale(LC_TIME, 'fr'); ?>
                        <div class="list-date">{{ \Carbon\Carbon::now()->formatLocalized('%B %d, %Y') }}</div>
                    </div>
                </div>
                <div class="col-xs-4">
                    <div class="list-head-summary-container">
                        <div class="list-pending">
                            <div class="list-count">{{ $alerts->count() }}</div>
                            <div class="list-label">non lus</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="mt-list-container list-default ext-1" style="padding: 0;">

            <ul>
                @foreach($alertes as $alerte)
                    <li class="mt-list-item done" id="notification_1">
                        <div class="list-icon-container">
                            <a href="javascript:;" onclick="delete_list_item(1)">
                                <i class="icon-close"></i>
                            </a>
                        </div>
                        <div class="list-datetime"> {{ $alerte->created_at ? $alerte->created_at->format('H:i') : ''  }}
                            <br> {{ $alerte->created_at ? $alerte->created_at->formatLocalized('%d %B') : ''  }}
                        </div>
                        <div class="list-item-content">
                            <h3 class="uppercase">
                                <a href="javascript:;">{!! strip_tags($alerte->message) !!}</a>
                            </h3>
                            <p>
                                @if($alerte->target_type == 'visit' || $alerte->target_type == 'task')
                                    <a href="{{ url('/visits/daily/'.$alerte->target_id) }}">Voir plus</a>
                                @elseif($alerte->target_type == 'ilv')
                                    <a href="{{ url('/ilv/detail/'.$alerte->target_id) }}">Voir plus</a>
                                @endif
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


@endsection

@section('footer')
    <script>
        function delete_list_item(x) {
            $('#notification_' + x).fadeOut(500, function () {
                $('#notification_' + x).remove();
            });
        }
    </script>
@endsection