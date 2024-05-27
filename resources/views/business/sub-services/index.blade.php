@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Sub Services</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                    <a href="{{route('sub-services.create')}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('sub-services.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="servicesName" name="servicesName" placeholder="Service Name">
                                            <input type="text" class="form-control mr-2" id="subServicesName" name="subServicesName" placeholder="Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('sub-services.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Service Name</th>
                                                    <th scope="col">Name</th>
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
                                                    <th scope="row" width="10%">{{$i}}</th>
                                                    <td width="40%">{{(isset($value->service->name))?$value->service->name:'N/A'}}</td>
                                                    <td width="40%">{{(isset($value->name))?$value->name:'N/A'}}</td>
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
                                                    <td width="10%">
                                                        <a href="{{route('sub-services.edit',$value->id)}}" class="btn create-icon"><i class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('sub-services.destroy', $value->id) }}" method="POST" class="d-none">
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
                                                    <td colspan="5" align="center">No Service Available</th>
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
@endsection
