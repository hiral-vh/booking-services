@extends('admin.layouts.app')
@section('content')

<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Business Owners</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="m-t-0 m-b-30">List</h4>
                                </div>
                                <div class="col-12 mb-3">
                                    <form class="form-inline" method="GET" action="{{ route('admin-business-owners.index') }}">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Search</label>
                                            <input type="text" class="form-control mr-2" id="services" name="services" placeholder="Services">
                                            <input type="text" class="form-control mr-2" id="name" name="name" placeholder="Name">
                                            <input type="text" class="form-control mr-2" id="email" name="email" placeholder="Email">
                                            <input type="text" class="form-control mr-2" id="mobile" name="mobile" placeholder="Mobile">
                                        </div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-l-10">Search</button>
                                        <a href="{{ route('admin-business-owners.index') }}"><button type="button" class="btn btn-primary waves-effect waves-light m-l-10">Reset</button></a>
                                    </form>
                                </div>

                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Subscription Plan</th>
                                                    <th>Subscription Start Date</th>
                                                    <th>Subscription End Date</th>
                                                    <th>Allow Appointments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $i = ($list->currentpage() - 1) * $list->perpage() + 1;
                                                @endphp
                                                @forelse ($list as $value)
                                                @php 
                                               $planName="";
                                                $allowedOrder = '';
                                                @endphp 
                                                 @if(isset($value->businessRecurringPaymentHistory[0]) &&($value->businessRecurringPaymentHistory[0]->plan_id == 0))

                                                @php $planName = 'Free Plan'; @endphp
                                                @php $allowedOrder = '100'; @endphp

                                                @else

                                                @php $planName = isset($value->businessRecurringPaymentHistory[0]) ? $value->businessRecurringPaymentHistory[0]->subscription->plan_name : $planName; @endphp
 
                                                @endif

                                              
                                                <tr>
                                                    <th width="5%">{{ $i }}</th>
                                                    <td width="15%">{{ (isset($value->name))?$value->name:'N/A' }}</td>
                                                    <td width="15%">{{ (isset($value->email))?$value->email:'N/A' }}</td>
                                                    <td width="15%">{{ (isset($value->country_code))?$value->country_code:'N/A'}}
                                                        {{(isset($value->contact))?$value->contact:'N/A'}}
                                                    </td>
                                                    <td width="10%">{{ (isset($value->businessRecurringPaymentHistory[0])) ? $planName:'N/A' }}</td>
                                                    <td width="10%">{{count($value->businessRecurringPaymentHistory) > 0 ?(date('d-m-Y h:i A',strtotime($value->businessRecurringPaymentHistory[0]->start_date))):'N/A'}}</td>
                                                    <td width="10%">{{count($value->businessRecurringPaymentHistory) > 0 ?(date('d-m-Y h:i A',strtotime($value->businessRecurringPaymentHistory[0]->end_date))):'N/A'}}</td>
                                                    <td width="10%">{{count($value->businessRecurringPaymentHistory) > 0 && $value->businessRecurringPaymentHistory[0]->subscription!=null ?$value->businessRecurringPaymentHistory[0]->subscription->allowed_order:$allowedOrder}}</td>
                                                </tr>
                                                @php
                                                $i++;
                                                @endphp
                                                @empty
                                                <tr>
                                                    <td colspan="6" align="center">No Users Available</th>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $list->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
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
@endsection
