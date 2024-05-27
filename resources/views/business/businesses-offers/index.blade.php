@extends('business.layouts.app')
@section('css')
<style>
    .main {
    margin-top: 5px;
    padding: 0 9px;
}

.main > .row {
    border: 1px solid #dee2e6;
}

.main > .row >.col-sm-6 {
padding:5px;
}
</style>
@endsection
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                <h4 class="page-title">Offers</h4>
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
                                <div class="col-9">
                                    <form class="form-inline" method="GET">
                                        <div class="form-group">
                                            <input type="text" class="form-control mr-2 mb-2" id="name" name="name" placeholder="Name" value="{{$name}}" maxlength="30">
                                            <input type="text" class="form-control mr-2 mb-2" id="price" name="price" placeholder="Price(£)" maxlength="10" value="{{$price}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="discount" name="discount" placeholder="Discount" maxlength="2" value="{{$discount}}">
                                            <input type="text" class="form-control mr-2 mb-2" id="coupon_code" name="coupon_code" placeholder="Coupon Code" maxlength="50" value="{{$couponCode}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light  mb-2">Search</button>
                                        <a href="{{ route('business-user-offers.index') }}" class="mb-2"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>
                                <div class="col-2" align="right">
                                    <a href="{{ route('business-user-offers.create') }}"><button type="button" class="btn waves-effect btn-secondary">Add <i class="ion ion-md-add"></i></button></a>
                                </div>
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                              <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Price(£)</th>
                                                <th scope="col">Discount</th>
                                                <th scope="col">Coupon Code</th>
                                                <th scope="col">Validity</th>
                                                {{-- <th scope="col">Status</th> --}}
                                                <th scope="col">Action</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = ($businessOffer->currentpage() - 1) * $businessOffer->perpage() + 1;
                                                @endphp
                                                @forelse ($businessOffer as $value)
                                                <tr id="offer_{{$value->id}}">
                                                    <th scope="row" width="70px">{{$i}}</th>
                                                    <td width="150px">{{isset($value->name)?$value->name:'N/A'}}</td>
                                                    @if(!empty($value->image))
                                                    <td width="100px" align="center">
                                                        <img src="{{ asset($value->image) }}"
                                                        alt="Offer" style="height:150px;width:150px">
                                                    </td>
                                                    @else
                                                    <td width="150px">
                                                        <img src="{{ asset('assets/images/NoImage.png') }}"
                                                        alt="Services" class="rounded-circle img-thumbnail" style="height:150px;width:150px">
                                                    </td>
                                                    @endif
                                                    @if($value->type==0)
                                                        <td width="100px"><span class="badge badge-success">Amount (₹)</span></td>
                                                    @else
                                                        <td width="100px"><span class="badge badge-warning">Percentage(%)</span></td>
                                                    @endif
                                                    <td width="70px">£{{(isset($value->price))?$value->price:'N/A'}}</td>
                                                    <td width="100px">{{(isset($value->discount))?$value->discount.'%':'N/A'}}</td>
                                                    <td width="150px">{{(isset($value->coupon_code))?$value->coupon_code:'N/A'}}</td>
                                                    <td width="100px">{{(isset($value->valid_till))?date('d-m-Y',strtotime($value->valid_till)):'N/A'}}</td>
                                                    {{-- <td width="50px">
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
                                                    <td width="80px">
                                                        <a href="{{route('business-user-offers.edit',$value->id)}}" class="btn create-icon"><i
                                                            class="fa fa-fw fa-edit"></i></a>

                                                            <a class="btn trash-icon" href="javascript:;"
                                                            onclick="openPopup({{ $value->id }}); "
                                                            data-popup="tooltip" title="Delete"><i
                                                                class="fa fa-fw fa-trash"></i></a>
                                                        <form id="Deletesubmit_{{ $value->id }}"
                                                            action="{{ route('business-user-offers.destroy', $value->id) }}"
                                                            method="POST" class="d-none">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="business_id" value="{{$value->business_id}}">
                                                        </form>
                                                    </td>
                                                </tr>
                                                @php
                                                    $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="9" align="center">No Offer Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                          </table>
                                          {{ $businessOffer->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
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
    @section('page-js')
    <script>
        $('#businessDetailMainMenu').addClass('active');
        $('#OffersMenu').addClass('active subdrop');
        $('#businessDetailMenu').css('display','block');

        $(document).on("change", ".toggle", function() {
            var id=$(this).attr('id');
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '{{route("businessUserofferStatus")}}',
                data: {
                    'id': id,
                    '_token':token
                },
                success: function(data) {
                    if(data ==1){
                        $("#offer_"+id).attr('checked',true);
                    }else{
                        $("#offer_"+id).attr('checked',false);
                    }

                }
            });
        });
    </script>
    @endsection
    @endsection
