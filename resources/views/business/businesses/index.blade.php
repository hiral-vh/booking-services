@extends('business.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business</h4>
            </div>
        </div>

        <div class="page-content-wrapper ">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-11">
                                        <h4 class="m-t-0 m-b-30">List</h4>
                                    </div>
                                    <div class="col-1">
                                        <a href="{{ route('business-user.create') }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Add"><i
                                                    class="ion ion-md-add"></i></button></a>
                                    </div>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">No</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Service</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $i = ($business->currentpage() - 1) * $business->perpage() + 1;
                                                    @endphp
                                                    @forelse ($business as $value)
                                                        <tr id="business_{{ $value->id }}">
                                                            <th scope="row" width="100px">{{ $i }}</th>
                                                            <td width="350px">{{ $value->name }}</td>
                                                            <td width="250px">
                                                                @foreach ($services as $service)
                                                                    @if ($value->service_id == $service->id)
                                                                        {{ $service->name }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                            <td width="60px">
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
                                                            </td>
                                                            <td width="170px">
                                                                <a href="{{ route('business-user.edit', $value->id) }}"
                                                                    class="btn create-icon"><i class="fa fa-fw fa-edit"
                                                                        title="Edit"></i></a>

                                                                <a class="btn trash-icon" href="javascript:;"
                                                                    onclick="openPopup({{ $value->id }}); "
                                                                    data-popup="tooltip" title="Delete"><i
                                                                        class="fa fa-fw fa-trash"></i></a>
                                                                <form id="Deletesubmit_{{ $value->id }}"
                                                                    action="{{ route('business-user.destroy', $value->id) }}"
                                                                    method="POST" class="d-none">
                                                                    @csrf
                                                                    @method('delete')
                                                                </form>

                                                                <a href="{{ route('business-user-about-us.index', ['business_id' => $value->id]) }}"
                                                                    class="btn create-icon"
                                                                    title="About {{ $value->name }}"><i
                                                                        class="fa fa-fw fa-info-circle"></i></a>

                                                                <a href="{{ route('business-user-service-index', $value->id) }}"
                                                                    class="btn create-icon"
                                                                    title="{{ $value->name }} Services"><i
                                                                        class="fa fa-wrench"></i></a>

                                                                <a href="{{ route('business-user-team-member-index', $value->id) }}"
                                                                    class="btn create-icon" title="Assign Team Members"><i
                                                                        class="fa fa-fw fa-users"></i></a>

                                                                <a href="{{ route('business-user-offer-index', $value->id) }}"
                                                                    class="btn create-icon" title="Offers"><i
                                                                        class="fas fa-gift"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $i++;
                                                        @endphp
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" align="center">No Business Available</th>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                            {{ $business->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
                url: "{{ route('businessStatus') }}",
                data: {
                    'id': id,
                    '_token': token
                },
                success: function(data) {
                    if (data == 1) {
                        $("#business_" + id).attr('checked', true);
                    } else {
                        $("#business_" + id).attr('checked', false);
                    }

                }
            });
        });
    </script>
@endsection
