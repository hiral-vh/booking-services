@extends('business.layouts.app')
@section('content')

<div class="content">

<div class="">
  <div class="page-header-title">
    <h4 class="page-title">Subscription Details</h4>
  </div>
</div>

<div class="page-content-wrapper ">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="card-tools">
            
            </div>
          </div>
          <div class="card-body" style="display: block;">
            <div class="row">
              <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                <div class="row">

                  <div class="col-12 col-sm-12">
                    <ul class="list-group list-group-unbordered subscription-ul">
                      <li class="list-group-item">
                        <b class="tblLength">Subscription Name</b><div class="category-section">{{(isset($list->plan_name))? $list->plan_name : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Start Date</b><div class="category-section">{{(isset($list->start_date))? $list->start_date : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">End Date</b><div class="category-section">{{(isset($list->end_date))? $list->end_date : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Price</b><div class="category-section">£{{(isset($list->plan_price))? $list->plan_price : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Description</b><div class="category-section">{!!  $list->plan_description !!}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Duration</b><div class="category-section">{{(isset($list->plan_duration))? $list->plan_duration : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Allowed Order</b><div class="category-section">{{(isset($list->allowed_order))? $list->allowed_order : 'N/A'}}</div>
                      </li>
                      <li class="list-group-item">
                        <b class="tblLength">Remaining Order</b><div class="category-section">{{(isset($list->numbers_of_appointment))? $list->numbers_of_appointment : 'N/A'}}</div>
                      </li>
                  </div>

                </div>
                <div class="btn-update mt-3 justify-content-start">
                    @if($list->plan_id == 1)
                      <div class="upgrade-btn-box">
                          <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade" title="Upgrade Subscription">Subscribe Plan</button></a>
                      </div>
                    @elseif($list->plan_id != 1)
                  
                        @if($list->cancel_subscription == 'cancel')
                      
                        <div class="upgrade-btn-box">
                            <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade mr-2" title="Upgrade Subscription">Subscribe Plan</button></a>
                        </div>
                        @else
                      
                        <div class="upgrade-btn-box">
                            <a href="{{route('cancel-subscription')}}"><button class="btn btn-upgrade mr-2" title="Cancel Subscription">Cancel Subscription</button></a>
                        </div>
                        <div class="upgrade-btn-box">
                              <a href="{{route('upgrade-subscription')}}"><button class="btn btn-upgrade" title="Upgrade Subscription">Upgrade Subscription</button></a>
                          </div>
                        @endif
                       

                    @endif
                  

                   
                </div>
              </div>
              <div style="height: 300px"></div>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->

    </div><!-- container -->

  </div> <!-- Page content Wrapper -->
</div> <!-- Page content Wrapper -->

</div> 
<!-- Page content Wrapper -->
</div>
<script>
    var success = "{{ Session::get('success') }}";
    var error = "{{ Session::get('error') }}";
</script>
@endsection
