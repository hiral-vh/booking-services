@extends('business.layouts.app')
@section('content')
    <div class="content">
        <div class="">
            <div class="page-header-title">
                @php
                    $title = '';
                @endphp
                <h4 class="page-title">About</h4>
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

                                    </div>
                                    <div class="col-1">
                                        @if (!empty($businessAboutUs))
                                            <a href="{{ route('business-user-about-us.edit', $businessAboutUs->id) }}"><button type="button"
                                                class="btn waves-effect btn-secondary" title="Edit"><i
                                                        class="fa fa-fw fa-edit"></i></button></a>
                                        @else
                                            <a href="{{ route('business-user-about-us.create') }}"><button type="button"
                                                    class="btn waves-effect btn-secondary" title="Add"><i
                                                        class="ion ion-md-add"></i></button></a>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            @if (!empty($businessAboutUs))
                                                <div class="row">
                                                    <div class="col-5">
                                                        @if (!empty($businessAboutUs->business->business_image))
                                                            <div class="bussiness-profile">
                                                                <img src="{{ asset($businessAboutUs->business->business_image) }}"
                                                                    alt="Business Profile Image">
                                                            </div>
                                                        @else
                                                            <div class="bussiness-profile">
                                                                <img src="{{ asset('assets/images/NoImage.png') }}"
                                                                    alt="Business Profile Image">
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="business-detail">
                                                            <div class="business-detail-inner">
                                                                <h5>email</h5>
                                                                <p>{{(!empty($businessAboutUs->business->email))?$businessAboutUs->business->email:'N/A' }}</p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>Address</h5>
                                                                <p>{{(!empty($businessAboutUs->business->address_line1))?$businessAboutUs->business->address_line1:'N/A'}}
                                                                    {{(!empty($businessAboutUs->business->address_line2))?$businessAboutUs->business->address_line2:'N/A' .' ' .(!empty($businessAboutUs->business->city)?$businessAboutUs->business->city:'N/A')}} -
                                                                    {{(!empty($businessAboutUs->business->zip_code))?$businessAboutUs->business->zip_code:'N/A' }}
                                                                </p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>contact number</h5>
                                                                <p>{{(!empty($businessAboutUs->business->country_code))?$businessAboutUs->business->country_code:'N/A' }}
                                                                    {{(!empty($businessAboutUs->business->contact))?$businessAboutUs->business->contact:'N/A'}}
                                                                </p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>About</h5>
                                                                @if($businessAboutUs->business->about != null)
                                                                <p class="about-para">
                                                                    {{ $businessAboutUs->business->about }}
                                                                </p>
                                                                @else
                                                                <p class="about-para">
                                                                    N/A
                                                                </p>
                                                                @endif

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-5">
                                                        <div class="bussiness-profile">
                                                            <img src="{{ asset('assets/images/NoImage.png') }}"
                                                                alt="images/">
                                                        </div>
                                                    </div>
                                                    <div class="col-7">
                                                        <div class="business-detail">
                                                            <div class="business-detail-inner">
                                                                <h5>email</h5>
                                                                <p>NA</p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>Address</h5>
                                                                <p>NA</p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>contact number</h5>
                                                                <p>NA</p>
                                                            </div>
                                                            <div class="business-detail-inner">
                                                                <h5>About</h5>
                                                                <p class="about-para">NA</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
        $('#businessDetailMainMenu').addClass('active');
        $('#aboutMenu').addClass('active subdrop');
        $('#businessDetailMenu').css('display','block');

        $(document).ready(function(e) {

        });
    </script>
    @endsection
@endsection
