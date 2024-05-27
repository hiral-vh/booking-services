@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Help & Support</h4>
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

                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Message</th>
                                                <th scope="col">Status</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($has->currentpage() - 1) * $has->perpage() + 1;
                                                @endphp
                                                @forelse ($has as $value)
                                                <tr id="has_{{ $value->id }}">
                                                    <th scope="row" width="30px">{{$i}}</th>
                                                    <td width="250px">{{$value->full_name}}</td>
                                                    <td width="500px">{{$value->email}}</td>
                                                    <td width="500px">{{$value->message}}</td>
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
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="4" align="center">No Help & Support Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $has->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
    $(document).on("change", ".toggle", function() {
        var id = $(this).attr('id');
        var token = $('meta[name="csrf-token"]').attr('content');

        if(this.checked) {
            toastr.success('Status active successfully', '', {
				timeOut: 5000
			});
        }else{
            toastr.success('Status de-active successfully', '', {
				timeOut: 5000
			});
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('hasStatus') }}",
            data: {
                'id': id,
                '_token': token
            },
            success: function(data) {
                if (data == 1) {
                    $("#has_" + id).attr('checked', true);
                } else {
                    $("#has_" + id).attr('checked', false);
                }

            }
        });
    });
</script>
@endsection
    @endsection
