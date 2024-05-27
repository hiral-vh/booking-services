@extends('business.layouts.app')
@section('content')

<div class="content">

<div class="">
  <div class="page-header-title">
    <h4 class="page-title">Video Details</h4>
  </div>
</div>

<div class="page-content-wrapper ">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body" style="display: block;">
            <div class="row">
                @foreach($list as $data)
                <div class="col-md-6">
                    <div class="card video-inner-card">
                            <div class="card-body"> 
                                <div class="title-videos">
                                    <h5>{{$data->title}}</h5>
                                   
                                    <h6>{!! substr($data->description, 0, 50) !!} @if(strlen($data->description) >= 50)... @endif</h6>
                                    <video class="video-player" controls>
                                        <source src="{{ asset($data->video) }}" type="video/mp4">
                                    </video>
                                        <div class="button-video">
                                        <a href="{{route('details-video',$data->id)}}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">View</button></a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
            </div>
              <div style="height: 300px"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->

    </div><!-- container -->

  </div> <!-- Page content Wrapper -->
</div> <!-- Page content Wrapper -->

</div> 
<!-- Page content Wrapper -->
</div>
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@endsection
