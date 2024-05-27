@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">User Address</h4>
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

                                <div class="col-10">
                                    <form class="form-inline" method="GET" action="{{route('user-address')}}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control" id="userName" name="userName" value="{{!empty($_GET['userName'])?$_GET['userName']:''}}" placeholder="User  ">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{route('user-address')}}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-1">
                                    <a href="{{route('dashboard')}}"><button type="button"
                                        class="btn waves-effect btn-secondary" title="Back"><i
                                            class="ion ion-md-arrow-back"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">User</th>
                                                <th scope="col">Address Line 1</th>
                                                <th scope="col">Street</th>
                                                <th scope="col">City</th>
                                                <th scope="col">Post Code</th>
                                                <th scope="col">Country Code</th>
                                                <th scope="col">Contact</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($userAddress->currentpage() - 1) * $userAddress->perpage() + 1;
                                                @endphp
                                                @forelse ($userAddress as $value)
                                                <tr>
                                                    <th scope="row" width="100px">{{$i}}</th>
                                                    <td width="750px">{{$value->user->name}}</td>
                                                    <td width="750px">{{$value->address_line1}}</td>
                                                    <td width="750px">{{$value->street}}</td>
                                                    <td width="550px">{{$value->city}}</td>
                                                    <td width="250px">{{$value->post_code}}</td>
                                                    <td width="400px">{{$value->country_code}}</td>
                                                    <td width="100px">{{$value->contact}}</td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No User Address Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $userAddress->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
