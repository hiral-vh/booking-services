@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">CMS</h4>
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
                                        <a href="{{ route('cms.create') }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Add">Add <i
                                                    class="ion ion-md-add"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Title</th>
                                                        <th scope="col">Description</th>
                                                        {{-- <th scope="col">Status</th> --}}
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = ($cms->currentpage() - 1) * $cms->perpage() + 1;
                                                    @endphp
                                                    @forelse ($cms as $value)
                                                        <tr id="cms_{{ $value->id }}">
                                                            <th scope="row" width="5%">{{ $i }}</th>
                                                            <td width="20%">{{ $value->title }}</td>
                                                            <td width="70%">{{ $value->description }} </td>
                                                            {{-- <td width="60px">
                                                                <div class="site-toggle">
                                                                    <input type="checkbox" id="{{ $value->id }}"
                                                                        data-status="{{ $value->status }}" @if ($value->status == 1)
                                                                    checked @endif name="toggle" class="toggle">
                                                                    <div class="main-toggle">
                                                                        <span class="on">On</span>
                                                                        <div class="circle"></div>
                                                                        <span class="off">Off</span>
                                                                    </div>
                                                                </div>
                                                            </td> --}}
                                                            <td width="5%">
                                                                <a href="{{ route('cms.edit', $value->id) }}"
                                                                    class="btn create-icon"><i
                                                                        class="fa fa-fw fa-edit"></i></a>
                                                                {{-- <a class="btn trash-icon" href="javascript:;"
                                                            onclick="openPopup({{ $value->id }}); "
                                                            data-popup="tooltip" title="Delete"><i
                                                                class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}"
                                                            action="{{ route('cms.destroy', $value->id) }}"
                                                            method="POST" class="d-none">
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
                                                            <td colspan="4" align="center">No CMS Available</th>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $cms->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
            var id = $(this).attr('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('CmsStatus') }}",
                data: {
                    'id': id,
                    '_token': token
                },
                success: function(data) {
                    if (data == 1) {
                        $("#cms_" + id).attr('checked', true);
                    } else {
                        $("#cms_" + id).attr('checked', false);
                    }

                }
            });
        });
    </script>

@endsection
