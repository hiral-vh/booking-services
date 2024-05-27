@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Food Category</h4>
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
                                    <a href="{{route('food-type.create')}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('food-type.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="name" name="name" placeholder="Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('food-category.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="80%">Category</th>
                                                    <th width="10%">Image</th>
                                                    <th width="5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($foodType->currentpage() - 1) * $foodType->perpage() + 1;
                                                @endphp
                                                @forelse ($foodType as $value)
                                                <tr>
                                                    <th width="5%">{{$i}}</th>
                                                    <td width="80%">{{(isset($value->food_category_name))?$value->food_category_name:'N/A'}}</td>
                                                    <td width="10%">
                                                        @if(empty($value->food_category_image))
                                                        <img src="{{ asset('assets/images/no-image.jpg') }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                        @else
                                                        <img src="{{ asset($value->food_category_image) }}"
                                                        alt="Image" class="logo-lg"
                                                        style="height:100px;width:100px" id="pic">
                                                        @endif
                                                    </td>
                                                    <td width="5%">
                                                        <a href="{{route('food-type.edit',$value->id)}}" title="Edit" class="btn create-icon"><i class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('food-type.destroy', $value->id) }}" method="POST" class="d-none">
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
                                                    <td colspan="4" align="center">No Food Category Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $foodType->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
