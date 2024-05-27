@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Admin</h4>
            </div>
        </div>
        <div class="page-content-wrapper ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                <div class="col-10">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-2" align="right">
                                    <a href="{{route('admin-create')}}" title="Add"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-10 mb-3">
                                    <form class="form-inline" method="GET" action="">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2" id="name" name="name" placeholder="Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('admin-index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Image</th>
                                                {{-- <th scope="col">Status</th> --}}
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($admin->currentpage() - 1) * $admin->perpage() + 1;
                                                @endphp
                                                @forelse ($admin as $value)
                                                <tr id="admin_{{$value->id}}">
                                                    <th scope="row" width="100px">{{$i}}</th>
                                                    <td width="300px">{{$value->name}}</td>
                                                    <td width="400px">{{$value->email}}</td>
                                                    @if(!empty($value->profile_image))
                                                    <td width="100px">
                                                        <img src="{{ asset($value->profile_image) }}"
                                                        alt="Admin" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @else
                                                    <td width="100px">
                                                        <img src="{{ asset('assets/images/users/nouser.png') }}"
                                                        alt="Admin" class="rounded-circle img-thumbnail" style="height:70px;width:70px">
                                                    </td>
                                                    @endif
                                                    <td width="80px">
                                                        <a href="{{ route('admin-edit', $value->id) }}" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit" title="Edit"></i></a>
                                                    <a class="btn trash-icon" href="javascript:;"
                                                        onclick="openPopup({{ $value->id }}); " data-popup="tooltip"
                                                        title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                    <form id="Deletesubmit_{{ $value->id }}"
                                                        action="{{ route('admin-delete', $value->id) }}"
                                                        method="POST" class="d-none">
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
                                                    <td colspan="6" align="center">No Admin Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $admin->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
