@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Subscription</h4>
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
                                    <a href="{{route('admin-subscription-create',$type)}}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Plan Name</th>
                                                <th scope="col">Description</th>
                                                <th scope="col">Duration(In Month)</th>
                                                <th scope="col">Allowed Order</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Stripe Plan id</th>
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($subscription->currentpage() - 1) * $subscription->perpage() + 1;
                                                @endphp
                                                @forelse ($subscription as $value)
                                                <tr>
                                                    <th scope="row" width="60px">{{$i}}</th>
                                                    <td width="150px">{{$value->plan_name}}</td>
                                                    <td width="500px">
                                                        {!! $value->plan_description !!}
                                                    </td>
                                                    <td width="200px">
                                                       {{$value->plan_duration}}
                                                    </td>
                                                    <td width="60px">
                                                        {{$value->allowed_order}}
                                                    </td>
                                                    <td width="60px">
                                                        £{{$value->plan_price}}
                                                    </td>
                                                    <td width="60px">
                                                        {{$value->stripe_plan_id}}
                                                    </td>
                                                    <td  width="80px">
                                                        <a href="{{URL::to('/')}}/admin-subcription/edit/{{$value->id}}/{{$type}}" title="Edit" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit"></i></a>
                                                        <a class="btn trash-icon" href="javascript:;" onclick="openPopup({{ $value->id }}); " data-popup="tooltip" title="Delete"><i class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}" action="{{ route('admin-subcription.destroy', $value->id) }}" method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                            <input type='hidden' id='type' name='type' value="{{$type}}">
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="8" align="center">No Subscription Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $subscription->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
