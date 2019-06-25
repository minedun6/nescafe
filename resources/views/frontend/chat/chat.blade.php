@extends('frontend.layouts.master')
@section('second-title')
    | Messagerie
@stop

@section('url-way')
    <li>
        <a href="{{url('/chat')}}">Messagerie</a>
    </li>
@stop

@section('header')

    <link href="/frontend/assets/apps/css/inbox.css" rel="stylesheet" type="text/css"/>
@endsection
@section('content')

    <div class="row">
        @roles(['Administrator', 'Superviseur', 'Super Administrator'])
        @if(isset($merchandisers))
            <div class="col-md-4">
                <div class="inbox">
                    <div class="inbox-sidebar">
                        <ul class="inbox-contacts" id="list_merch">
                            @foreach($merchandisers as $index => $merchandiser)
                                <li class="divider margin-bottom-5"></li>
                                <li class="merchan_list" data-index="{{ $index }}" id="merch_nom[{{ $index }}]">
                                    <a>
                                        <span class="contact-name"> <i class="fa fa-user"></i> {{ $merchandiser->name }}</span>
                                        <input type="hidden" value="{{ $merchandiser->id }}" id="client_id{{ $index }}">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        @endauth
        <div class="col-md-8">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bubble font-blue-steel"></i>
                        <span class="caption-subject font-blue-steel bold uppercase">Messagerie</span>
                    </div>
                    <div class="actions">

                    </div>
                </div>
                <div class="portlet-body" id="chats">
                    <div class="scroller" data-always-visible="1"
                         data-rail-visible1="1" style="min-height: 300px;">
                        <ul class="chats" id="messenger_body">

                        </ul>
                    </div>
                    <div class="chat-form">
                        <div class="input-cont">
                            <input type="hidden" id="receiver_id" value="0">
                            <input class="form-control" id="btn-input" type="text"
                                   placeholder="Ecrire votre message ici..."/></div>
                        <div class="btn-cont">
                            <span class="arrow"> </span>
                            <button class="btn blue icn-only" id="btn-chat">
                                <i class="fa fa-check icon-white"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



@endsection
@section('footer')
    <script>
        $(function () {
            $(document).on('click', '.merchan_list', function () {
                var input = $('#btn-input');
                var cont = $('#chats');
                var length = $('ul#list_merch li').length / 2;
                var index = $(this).data('index');
                for (i = 0; i < length; i++) {
                    var x = '#merch_nom[' + i + ']';
                    if (i != index)
                        document.getElementById("merch_nom[" + i + "]").style.backgroundColor = "white";
                }
                var client_id = $('#client_id' + index).val();
                $('#receiver_id').val(client_id);
                document.getElementById("merch_nom[" + index + "]").style.backgroundColor = "rgba(242,243,243,1)";

                $.ajax({
                    'url': "{{ url('/chat/get_messages') }}",
                    'type': 'post',
                    'data': {
                        'merch_id': client_id,
                        '_token': "{!! csrf_token() !!}"
                    },
                    success: function (messages) {
                        $("#messenger_body").empty();
                        $.each(messages, function () {
                            var content = '';

                            if (this.sender_id != client_id) {

                                var vue = '';
                                if (this.is_seen == 1) {
                                    vue = ' (vu le ' + this.date_seen + ')';
                                }
                                content = '<li class="out">' +
                                        ' <img class="avatar" alt="" src="/frontend/assets/layouts/layout/img/avatar.png" />' +
                                        ' <div class="message">' +
                                        ' <span class="arrow"> </span>' +
                                        ' <a href="javascript:;" class="name">' + this.name + '</a>' +
                                        ' <span class="datetime"> ' + this.time + vue + '</span>' +
                                        ' <span class="body"> ' + this.message + '</span>' +
                                        '</div>' +
                                        '</li>';


                            } else {
                                content = '<li class="in">' +
                                        ' <img class="avatar" alt="" src="/frontend/assets/layouts/layout/img/avatar.png" />' +
                                        ' <div class="message">' +
                                        ' <span class="arrow"> </span>' +
                                        ' <a href="javascript:;" class="name">' + this.name + '</a>' +
                                        ' <span class="datetime"> ' + this.time + '</span>' +
                                        ' <span class="body"> ' + this.message + '</span>' +
                                        '</div>' +
                                        '</li>';
                            }
                            $("#messenger_body").append(content);

                        });
                        var getLastPostPos = function () {
                            var height = 0;
                            cont.find("li.out, li.in").each(function () {
                                height = height + $(this).outerHeight();
                            });

                            return height;
                        }

                        cont.find('.scroller').slimScroll({
                            scrollTo: getLastPostPos() + 100
                        });
                    }

                });


            });

            $(document).on('click', '#btn-chat', function () {
                var cont = $('#chats');
                var receiver_id = $('#receiver_id').val();
                var message = $('#btn-input').val();
                if (receiver_id != '' && message != '') {
                    $.ajax({
                        'url': "{{ url('/chat/send_message') }}",
                        'type': 'post',
                        'data': {
                            'receiver_id': receiver_id,
                            'message': message,
                            '_token': "{!! csrf_token() !!}"
                        },
                        success: function (message) {
                            content = '<li class="out">' +
                                    ' <img class="avatar" alt="" src="/frontend/assets/layouts/layout/img/avatar.png" />' +
                                    ' <div class="message">' +
                                    ' <span class="arrow"> </span>' +
                                    ' <a href="javascript:;" class="name">' + message.name + '</a>' +
                                    ' <span class="datetime"> ' + message.time + '</span>' +
                                    ' <span class="body"> ' + message.message + '</span>' +
                                    '</div>' +
                                    '</li>';
                            $("#messenger_body").append(content);
                            $("#btn-input").val('');
                            var getLastPostPos = function () {
                                var height = 0;
                                cont.find("li.out, li.in").each(function () {
                                    height = height + $(this).outerHeight();
                                });

                                return height;
                            }
                            cont.find('.scroller').slimScroll({
                                scrollTo: getLastPostPos() + 100
                            });

                        }
                    });
                }

                return false;
            });
            $('#btn-input').bind('keydown', function (event) {
                if((event.keyCode || event.charCode) !== 13) return true;
                $('#btn-chat').click();
                return false;
            });
        });


    </script>
    @role('Merch')
    <script>
        $(document).ready(function () {

            var input = $('#btn-input');
            var cont = $('#chats');

            var index = $(this).data('index');

            var client_id = {{ \Auth::user()->id }};
            $.ajax({
                'url': "{{ url('/chat/get_messages') }}",
                'type': 'post',
                'data': {
                    'merch_id': client_id,
                    '_token': "{!! csrf_token() !!}"
                },
                success: function (messages) {
                    $("#messenger_body").empty();
                    $.each(messages, function () {
                        var content = '';

                        if (this.sender_id == {{ \Auth::user()->id }} ) {

                            content = '<li class="out">' +
                                    ' <img class="avatar" alt="" src="/frontend/assets/layouts/layout/img/avatar.png" />' +
                                    ' <div class="message">' +
                                    ' <span class="arrow"> </span>' +
                                    ' <a href="javascript:;" class="name">' + this.name + '</a>' +
                                    ' <span class="datetime"> ' + this.time + '</span>' +
                                    ' <span class="body"> ' + this.message + '</span>' +
                                    '</div>' +
                                    '</li>';


                        } else {
                            content = '<li class="in">' +
                                    ' <img class="avatar" alt="" src="/frontend/assets/layouts/layout/img/avatar.png" />' +
                                    ' <div class="message">' +
                                    ' <span class="arrow"> </span>' +
                                    ' <a href="javascript:;" class="name">' + this.name + '</a>' +
                                    ' <span class="datetime"> ' + this.time + '</span>' +
                                    ' <span class="body"> ' + this.message + '</span>' +
                                    '</div>' +
                                    '</li>';
                        }
                        $("#messenger_body").append(content);

                    });
                    var getLastPostPos = function () {
                        var height = 0;
                        cont.find("li.out, li.in").each(function () {
                            height = height + $(this).outerHeight();
                        });

                        return height;
                    }

                    cont.find('.scroller').slimScroll({
                        scrollTo: getLastPostPos() + 100
                    });
                }

            });
        });
    </script>
    @endauth
@endsection