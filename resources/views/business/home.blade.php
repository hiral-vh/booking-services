@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Team Members</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-11">
                                    <h4 class="m-t-0 m-b-30">Add</h4>
                                </div>
                                <div class="col-1">

                                </div>
                                <div class="col-12">
                                    <center>
                                        <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()" class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                                    </center>
                                    <div class="card">
                                        <div class="card-header">{{ __('Dashboard') }}</div>

                                        <div class="card-body">
                                            @if (session('status'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('status') }}
                                            </div>
                                            @endif

                                            <form action="{{ route('send.notification') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="title">
                                                </div>
                                                <div class="form-group">
                                                    <label>Body</label>
                                                    <textarea class="form-control" name="body"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Send Notification</button>
                                            </form>
                                        </div>
                                    </div>
                                </div> <!-- card-body -->
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->

        </div>
        <!-- Page content Wrapper -->

    </div>
    <script>
        var success = "{{ Session::get('success') }}";
        var error = "{{ Session::get('error') }}";
    </script>

    @endsection