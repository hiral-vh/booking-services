@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Business FAQS</h4>
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
                                    <a href="{{route('faq.create')}}"><button type="button" class="btn waves-effect btn-secondary" title="Add">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Question</th>
                                                <th scope="col">Answer</th>
                                                {{-- <th scope="col">Status</th> --}}
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($faq->currentpage() - 1) * $faq->perpage() + 1;
                                                @endphp
                                                @forelse ($faq as $value)
                                                <tr id="faq_{{$value->id}}">
                                                    <th scope="row" width="50px">{{$i}}</th>
                                                    <td width="250px">{{$value->question}}</td>
                                                    <td width="500px">{{$value->answer}}</td>
                                                    {{-- <td width="100px">
                                                        <div class="site-toggle">
                                                            <input type="checkbox" id="{{$value->id}}"
                                                                data-status="{{$value->status}}" @if($value->status ==1)
                                                            checked @endif name="toggle" class="toggle">
                                                            <div class="main-toggle">
                                                                <span class="on">On</span>
                                                                <div class="circle"></div>
                                                                <span class="off">Off</span>
                                                            </div>
                                                        </div>
                                                    </td> --}}
                                                    <td width="70px">
                                                        <a href="{{route('faq.edit',$value->id)}}" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit"></i></a>
                                                            <a class="btn trash-icon" href="javascript:;"
                                                            onclick="openPopup({{ $value->id }}); "
                                                            data-popup="tooltip" title="Delete"><i
                                                                class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}"
                                                            action="{{ route('faq.destroy', $value->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="deleted_by" id="deleted_by" value="{{Auth::guard('admin')->user()->id}}">
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="5" align="center">No FAQ Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $faq->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
            var id=$(this).attr('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('update-faq-status') }}",
                data: {
                    'id': id,
                    '_token':token
                },
                success: function(data) {
                    if(data == 1){
                        $("#faq_"+id).attr('checked',true);
                    }else{
                        $("#faq_"+id).attr('checked',false);
                    }
                }
            });
        });
    </script>
    @endsection
