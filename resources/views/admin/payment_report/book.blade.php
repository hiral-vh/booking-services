@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Book IT Subscription</h4>
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
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('get-bookit-report') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="businessName" name="businessName" placeholder="Business Name" value="{{$businessName}}">
                                            <input type="text" class="form-control mr-2" id="userName" name="userName" placeholder="User Name" value="{{$userName}}">
                                            <input type="text" class="form-control mr-2" id="planName" name="planName" placeholder="Plan Name" value="{{$planName}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('get-bookit-report') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Bussiness Name</th>
                                                <th scope="col">User Name</th>
                                                <th scope="col">Plan Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Date</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                
                                            
                                                @php
                                                    $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $data)
                                                <tr>
                                                    <th>{{$i}}</th>
                                                    <td>{{$data->business!=null ? $data->business->name : 'N/A'}}</td>
                                                    <td>{{$data->business->businessUser!=null ? $data->business->businessUser->name : 'N/A'}}</td>
                                                    <td>
                                                        {{$data->subscription->plan_name}}
                                                    </td>
                                                    <td>
                                                       {{$data->subscription->plan_price}}
                                                    </td>
                                                    <td>
                                                        {{$data->created_at}}
                                                    </td>
                                                 
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No Purchase Available</th>
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
