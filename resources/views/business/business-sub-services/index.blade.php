@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Services</h4>
        </div>
    </div>
    <div class="page-content-wrapper ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-1">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-9">
                                    <form class="form-inline" method="GET">
                                        <div class="form-group">
                                            @php
                                                $subServiceArray=array();
                                            @endphp

                                            <select class="form-control mr-2 mb-2" id="sub_service" name="sub_service">
                                                <option value="">Select Service</option>
                                                @foreach ($subServices as $value)
                                                    @if (isset($value->subService))
                                                        @if(!in_array($value->subService->id,$subServiceArray))
                                                            <option {{(isset($value->subService->id) && $value->subService->id==$requestSubService)?'selected':''}} value="{{(isset($value->subService->id))?$value->subService->id:'N/A'}}">{{(isset($value->subService->name))?$value->subService->name:'N/A'}}</option>
                                                        @endif
                                                        @php
                                                            array_push($subServiceArray,$value->subService->id);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </select>
                                            <input type="text" class="form-control mr-2 mb-2" id="name" name="name" placeholder="Name" value="{{$requestName}}" maxlength="30">
                                            <input type="text" class="form-control mr-2 mb-2" id="price" name="price" placeholder="Price(£)" maxlength="10" value="{{$requestPrice}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="time" name="time" placeholder="Time" maxlength="3" value="{{$requestTime}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light  mb-2">Search</button>
                                        <a href="{{ route('business-owner-subservices.index') }}" class="mb-2"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-2" align="right">
                                    <a href="{{route('business-owner-subservices.create')}}"><button type="button" class="btn waves-effect btn-secondary  mb-3" {{($checkKey==0)?'disabled':''}} title="{{($checkKey==0)?'Please enter Stripe Key':'Add'}}">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Service Name</th>
                                                    <th scope="col">Name</th>
                                                    <!-- <th scope="col">Price(£)</th> -->
                                                    <th scope="col">Time(In Minutes)</th>
                                                    {{-- <th scope="col">Status</th> --}}
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $value)
                                                <tr id="service_{{$value->id}}">
                                                    <th scope="row">{{$i}}</th>
                                                    <td>{{(isset($value->subService->name))?$value->subService->name:'N/A'}}</td>
                                                    <td>{{(isset($value->name))?$value->name:'N/A'}}</td>
                                                    <!-- <td>£{{(isset($value->price))?$value->price:'N/A'}}</td> -->
                                                    <td>{{(isset($value->time))?$value->time:'N/A'}}</td>
                                                    {{-- <td width="60px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{$value->id}}" data-status="{{$value->status}}" @if($value->status ==1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> --}}
                                                    <td>
                                                        <a href="{{route('business-owner-subservices.edit',$value->id)}}" class="btn create-icon"><i class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('business-owner-subservices.destroy', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="7" align="center">No Business Service Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $list->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
@section('page-js')
<script>
    $('#businessDetailMainMenu').addClass('active');
    $('#businessSubServicesMenu').addClass('active subdrop');
    $('#businessDetailMenu').css('display','block');

    $(document).ready(function(e){
        $('#price').on('input', function (event) {
            this.value = this.value.replace(/[^0-9.]/g, '');
        });

        $('#time').on('input', function (event) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('subServicesStatus')}}",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#service_" + id).attr('checked', true);
                } else {
                    $("#service_" + id).attr('checked', false);
                }
            }
        });
    });
</script>
@endsection
@endsection
