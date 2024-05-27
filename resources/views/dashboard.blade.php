@extends('admin.layouts.app')
@section('content')
@section('css')
    <style>
        .card-height {
            min-height: calc(100vh - 228px);
        }

    </style>
@endsection
@if ($errors->any())
    toastr.success("Email is incorrect");
@endif
<div class="content">
    <div class="">
        <div class="page-header-title">
            <h4 class="page-title">Dashboard</h4>
        </div>
    </div>

    <div class="page-content-wrapper ">

        <div class="container-fluid">
            <div class="card card-height">
                <div class="card-body">
                    <div class="dashboard-title">
                        <h5>Business</h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#fd8442" value="{{ (!empty($subscribedUsers))?$subscribedUsers:'N/A' }}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3">
                                            <h2 class="text-primary sub-fonts  mb-0">{{(!empty($subscribedUsers))?$subscribedUsers:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Subscribed Users</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#bb96ea" value="{{(!empty($totalSales))?$totalSales:'N/A'  }}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3 ">
                                            <h2 class="text-purple mb-0 sub-fonts ">&#65505;{{ (!empty($totalSales))?$totalSales:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Total Sales</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="dashboard-title">
                        <h5>Restaurant</h5>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#fd8442" value="{{ (!empty($restaurantUsers))?$restaurantUsers:'N/A' }}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3">
                                            <h2 class="text-primary sub-fonts  mb-0">{{ (!empty($restaurantUsers))?$restaurantUsers:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Total Users</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#bb96ea" value="{{ (!empty($orders))?$orders:'N/A'  }}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3">
                                            <h2 class="text-purple  sub-fonts  mb-0">{{ (!empty($orders))?$orders:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#fd8442" value="{{(!empty($category))?$category:'N/A'}}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3">
                                            <h2 class="text-primary sub-fonts  mb-0">{{ (!empty($category))?$category:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Categories</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card">
                                <div class="card-heading p-4">
                                    <div class="d-flex">
                                        <input class="knob" data-width="80" data-height="80"
                                            data-linecap=round data-fgColor="#bf9ee7" value="{{ (!empty($restaurantOwners))?$restaurantOwners:'N/A' }}"
                                            data-skin="tron" data-angleOffset="180" data-readOnly=true
                                            data-thickness=".15" />
                                        <div class="float-right pl-3">
                                            <h2 class="text-purple sub-fonts mb-0">{{ (!empty($restaurantOwners))?$restaurantOwners:'N/A' }}</h2>
                                            <p class="text-muted mb-0 mt-2 dashtext-ellip ">Restaurant Owners</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <!-- end row -->

        </div>
        <!-- container-fluid -->

    </div>
    <!-- Page content Wrapper -->

</div>
<!-- content -->
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@endsection
