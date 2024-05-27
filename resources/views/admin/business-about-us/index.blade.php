@extends('admin.layouts.app')
@section('content')

    <div class="content">
        <div class="">
            <div class="page-header-title">
                @php
                    $title="";
                @endphp
                <h4 class="page-title">About {{ ucfirst($business->name) }}
                </h4>
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
                                <div class="col-2">
                                        @if(!empty($businessAboutUs))
                                        <a href="{{ route('business-admin.index') }}"><button type="button"
                                            class="btn waves-effect btn-secondary"><i
                                                class="ion ion-md-arrow-back" title="back"></i></button></a>
                                                <a href="{{route('business-about-us.edit',[$businessAboutUs->id,'business_id'=>$business->id])}}"><button type="button"
                                                    class="btn waves-effect btn-secondary" title="Edit"><i
                                                    class="fa fa-fw fa-edit" style="color: #fff;"></i></a>
                                        @else
                                        <a href="{{ route('business-admin.index') }}"><button type="button"
                                            class="btn waves-effect btn-secondary"><i
                                                class="ion ion-md-arrow-back" title="back"></i></button></a>
                                        <a href="{{route('business-about-us.create',['business_id'=>$business->id])}}"><button type="button" class="btn waves-effect btn-secondary" title="Add"><i class="ion ion-md-add"></i></button></a>
                                        @endif
                                </div>
                                <div class="col-12">
                                    <div>
                                        @if(!empty($businessAboutUs))
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="bussiness-profile">
                                                    <img src="{{asset($businessAboutUs->image)}}" alt="images/">
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="business-detail">
                                                    <div class="business-detail-inner">
                                                        <h5>location</h5>
                                                        <p>{{$businessAboutUs->location}}</p>
                                                    </div>
                                                    <div class="business-detail-inner">
                                                        <h5>contact number</h5>
                                                    <p>({{$businessAboutUs->country_code}}){{$businessAboutUs->contact}}</p>
                                                    </div>
                                                    <div class="business-detail-inner">
                                                        <h5>About</h5>
                                                    <p class="about-para">{{$businessAboutUs->description}}</p>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-5">
                                                <div class="bussiness-profile">
                                                    <img src="{{asset('assets/images/NoImage.Png')}}" alt="images/">
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="business-detail">
                                                    <div class="business-detail-inner">
                                                        <h5>location</h5>
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
    @endsection
