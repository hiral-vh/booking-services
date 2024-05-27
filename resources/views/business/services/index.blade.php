@extends('business.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Services</h4>
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
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-1">
                                    <a href="{{route('business-user-services.create')}}"><button type="button" class="btn waves-effect btn-secondary"><i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($service->currentpage() - 1) * $service->perpage() + 1;
                                                @endphp
                                                @forelse ($service as $value)
                                                <tr id="service_{{$value->id}}">
                                                    <th scope="row" width="100px">{{$i}}</th>
                                                    <td width="750px">{{$value->name}}</td>
                                                    @if(!empty($value->image))
                                                    <td width="100px">
                                                        <img src="{{ asset('assets/images/services') }}/{{$value->image}}"
                                                        alt="Services" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @else
                                                    <td width="100px">
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}"
                                                        alt="Services" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @endif
                                                    <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{$value->id}}"
                                                                data-status="{{$value->status}}" @if($value->status ==1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{route('business-user-services.edit',$value->id)}}" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit"></i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="5" align="center">No Service Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $service->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
                                    </div>
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
    <script>
        $(document).on("change", ".toggle", function() {
            var id=$(this).attr('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{route('serviceStatus')}}",
                data: {
                    'id': id,
                    '_token':token
                },
                success: function(data) {
                    if(data ==1){
                        $("#service_"+id).attr('checked',true);
                    }else{
                        $("#service_"+id).attr('checked',false);
                    }

                }
            });
        });
    </script>
    @endsection
