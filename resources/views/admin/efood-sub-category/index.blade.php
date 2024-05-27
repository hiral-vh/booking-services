@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Food Sub Category</h4>
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
                                    <a href="{{route('food-sub-category.create')}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('food-sub-category.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="categoryName" name="categoryName" placeholder="Category">
                                            <input type="text" class="form-control mr-2" id="subCategoryName" name="subCategoryName" placeholder="Name">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('food-sub-category.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th width="45%">Category</th>
                                                    <th width="45%">Name</th>
                                                    <th width="5%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $value)
                                                <tr>
                                                    <th scope="row" width="5%">{{$i}}</th>
                                                    <td width="45%">{{(isset($value->cateogry->name))?$value->cateogry->name:'N/A'}}</td>
                                                    <td width="45%">{{(isset($value->name))?$value->name:'N/A'}}</td>
                                                    <td width="5%">
                                                        <a href="{{route('food-sub-category.edit',$value->id)}}" class="btn create-icon" title="Edit"><i class="fa fa-fw fa-edit"></i></a>
                                                        {{-- <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('food-sub-category.destroy', $value->id) }}" method="POST" class="d-none">
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
                                                    <td colspan="4" align="center">No Food Sub Category Available</th>
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
