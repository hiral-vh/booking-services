@extends('business.layouts.app')
@section('css')
    <style>
        .notifi-details {
            display: flex;
            margin-bottom: 8px;
            margin-top: 8px;
        }

        .notific-icons i {
            color: #fff;
            font-size: 19px;
        }

        .notification-main {
            border-bottom: 1px solid #c5c3c9;
        }

        .notific-icons {
            height: 45px;
            width: 45px;
            background: #ef5c6a !important;
            border-radius: 50%;
            display: flex;
            align-items: center;
            margin-right: 10px;
            justify-content: center;
        }

        p.notifi-head {
            margin-bottom: 1px;
            font-weight: 700;
            font-size: 14px;
        }

        p.notifi-order {
            margin-bottom: 1px;
        }

        .flex-width {
            width: 56px;
        }

        .notification-main:last-child {
            border-bottom: 0px;
        }

        .markAsReadText:hover
        {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Notifications</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12" id="main-row">
                                        @forelse ($businessNotification as $value)
                                        <div id="notification_{{$value->id}}" class='notification-div'>
                                            <div class="notification-main">
                                                <div class="notifi-details">
                                                    <div class="flex-width">
                                                        <div class="notific-icons">
                                                            <i class="mdi mdi-message-text-outline"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-text">
                                                        <p class="notifi-head">@if($value->notification_type == '5' ||$value->notification_type == '6') <a href="{{route('subscription')}}"> @endif {{ $value->title ? $value->title : 'N/A' }}
                                                        </a>
                                                        </p>
                                                        <p class="notifi-order markAsReadText" onclick="markAsRead({{$value->id}});">
                                                            {{ $value->message ? $value->message : 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @empty
                                        <div>
                                            <div class="notification-main">
                                                <div class="notifi-details">
                                                    <div class="flex-width">
                                                        <div class="notific-icons">
                                                            <i class="mdi mdi-cart-outline"></i>
                                                        </div>
                                                    </div>
                                                    <div class="notification-text">
                                                        <p class="notifi-head">No Notifications Here</p>
                                                        <p class="notifi-order">-</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>
    @section('page-js')
        <script>
            $(document).ready(function(e){
                notifications();
            });
            function markAsRead(id)
            {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{route('markAsReadNotificationById')}}",
                    data: {

                        'notification_id': id,
                        '_token': '{{csrf_token()}}',
                    },
                    success: function(response) {
                        var html1='';
                        var html2='';
                        $(".notification-div").html('');
                        $("#notification-badge").html(response.data);
                        html2='<div class="notification-main"><div class="notifi-details">\
                                        <div class="flex-width">\
                                            <div class="notific-icons">\
                                                <i class="mdi mdi-message-text-outline"></i>\
                                            </div>\
                                        </div>\
                                        <div class="notification-text">\
                                            <p class="notifi-head">No Notifications Here </p>\
                                            <p class="notifi-order">-</p>\
                                        </div>\
                                    </div></div>';
                        if(response.status==1)
                        {
                            $(response.notification).each(function(index,value){
                                html1='<div class="notification-main"><div class="notifi-details">\
                                            <div class="flex-width">\
                                                <div class="notific-icons">\
                                                    <i class="mdi mdi-message-text-outline"></i>\
                                                </div>\
                                            </div>\
                                            <div class="notification-text">\
                                                <p class="notifi-head">'+value.title+'</p>\
                                                <p class="notifi-order markAsReadText" onclick="markAsRead('+value.id+');">'+value.message+'</p>\
                                            </div>\
                                        </div></div>';
                                        $("#notification_"+value.id).append(html1);
                            });
                        }
                        if(response.status==0){
                            $("#main-row").append(html2);
                        }
                    }
                });
            }
        </script>
    @endsection
@endsection
