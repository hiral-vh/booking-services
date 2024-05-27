@extends('business.layouts.app')
@section('content')
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Details</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-12 ">
                                    <h4 class="m-t-0 m-b-15 text-center">{{(!empty($details->title))?$details->title:'N/A'}}</h4>
                                    <div class="new-video text-center">
                                    <video class="video-player" controls>
                                        <source src="{{ asset($details->video) }}" type="video/mp4">
                                    </video>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <a href="{{$details->url}}">{{$details->url}}</a>
                                </div>
                                <div class="col-12">
                                    <p class="m-t-0 m-b-15">{!! wordwrap("$details->description",500,"<br>\n",true); !!}</p>
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
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@section('js')
<script>
    $('#appointmentsMenu').addClass('active');
</script>
@endsection
@endsection
