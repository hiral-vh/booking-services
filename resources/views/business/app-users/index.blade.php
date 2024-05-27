@extends('business.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">App Users</h4>
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
                                <div class="col-11">
                                    <form class="form-inline" method="GET">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2 mb-2" id="name" name="name" placeholder="Name" value="" maxlength="30" value="{{$name}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="email" name="email" placeholder="Email" maxlength="100" value="{{$email}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="mobile" name="mobile" placeholder="Mobile" maxlength="10" value="{{$mobile}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light  mb-2">Search</button>
                                        <a href="{{ route('app-users') }}" class="mb-2"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
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
                                                    <th scope="col">Mobile</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($appUsers->currentpage() - 1) * $appUsers->perpage() + 1;
                                                @endphp
                                                @forelse ($appUsers as $value)
                                                <tr>
                                                    <th width="5%">{{ $i }}</th>
                                                    <td width="20%">{{isset($value->first_name)?$value->first_name:'N/A' }}
                                                        {{isset($value->last_name)?' '.$value->last_name:'N/A' }}
                                                    </td>
                                                    <td width="30%">{{ (isset($value->email))?$value->email:'N/A' }}</td>
                                                    <td width="20%">({{ ((isset($value->country_code))?$value->country_code:'N/A') }})
                                                        {{ (isset($value->mobile))?$value->mobile:'N/A' }}</td>
                                                    <td width="5%"> <a class="btn trash-icon" href="{{route('app-users-show',$value->id)}}" data-popup="tooltip" title="Show"><i class="fa fa-fw fa-eye" style="color:black"></i></a></td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="5" align="center">No App Users Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $appUsers->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
@section('js')
<script>
    $('#appUsersMenu').addClass('active');
</script>
@endsection
@endsection
