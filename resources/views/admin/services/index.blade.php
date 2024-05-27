@extends('admin.layouts.app')
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
                                <div class="col-12 d-flex justify-content-between">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                    <a href="{{route('services.create')}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('services.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="servicesName" name="servicesName" placeholder="Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('services.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="80%">Name</th>
                                                    <th width="10%">Image</th>
                                                    <th width="5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($service->currentpage() - 1) * $service->perpage() + 1;
                                                @endphp
                                                @forelse ($service as $value)
                                                <tr>
                                                    <th width="5%">{{$i}}</th>
                                                    <td width="80%">{{(isset($value->name))?$value->name:'N/A'}}</td>
                                                    @if(!empty($value->image))
                                                    <td width="10%">
                                                        <img src="{{ asset($value->image)}}" alt="Services" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @else
                                                    <td width="10%">
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}" alt="Services" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @endif
                                                    <td width="5%">
                                                        <a href="{{route('services.edit',$value->id)}}" class="btn create-icon" title="Edit"><i class="fa fa-fw fa-edit"></i></a>
                                                        {{-- <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('services.destroy', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                        </form> --}}
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
@endsection
